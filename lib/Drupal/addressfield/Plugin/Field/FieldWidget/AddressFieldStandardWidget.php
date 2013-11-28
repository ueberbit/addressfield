<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\Field\FieldWidget\AddressFielddynamicWidget.
 */

namespace Drupal\addressfield\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Plugin implementation of the 'addressfield_standard' widget.
 *
 * @FieldWidget(
 *   id = "addressfield_standard",
 *   label = @Translation("Dynamic address form"),
 *   field_types = {
 *     "addressfield"
 *   },
 *   settings = {
 *     "format_handlers" = {
 *       "address"
 *     }
 *   }
 * )
 */
class AddressFieldStandardWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, array &$form_state) {
    // Determine the list of available countries, and if the currently selected
    // country is not in it, unset it so it can be reset to the default country.
    $pluginManager = \Drupal::service('plugin.manager.addressfield');

    // Generate a specific key used to identify this element to restore a default
    // value upon AJAX submission regardless of where this element is in the
    // $form array.
    $element_key = implode('|', array($element['#entity_type'], $element['#bundle'], $element['#field_name'], $element['#language'], $element['#delta']));

    // Store the key in the element array as a value so it can be easily retrieved
    // in context in the $form_state['values'] array in the element validator.
    $element['element_key'] = array(
      '#type' => 'value',
      '#value' => $element_key,
    );

    // Get the default address used to build the widget form elements, looking
    // first in the form state, then in the stored value for the field, and then
    // in the default values of the instance.
    $address = array();

    if (!empty($form_state['addressfield'][$element_key])) {
      // Use the value from the form_state if available.
      $address = $form_state['addressfield'][$element_key];
    }
    else {
      // Else use the saved value for the field or instance default.
      $address = $items[$delta]->getValue();
    }

    // Generate the address form.
    $context = array(
      'mode' => 'form',
      'field' => $this->fieldDefinition->getField(),
      'instance' => $this->fieldDefinition,
//      'langcode' => $langcode,
      'delta' => $delta,
    );

    foreach ($this->getSetting('format_handlers') as $handler) {
      $handler = $pluginManager->createInstance($handler);
      $handler->format($element, $address, $context);
    }

    // Store the address in the format, for processing.
    $element['#address'] = $address;

    // Post-process the format stub, depending on the rendering mode.
    if ($context['mode'] == 'form') {
      $element['#addressfield'] = TRUE;
      $element['#process'][] = 'addressfield_process_format_form';
    }
    elseif ($context['mode'] == 'render') {
      $element['#pre_render'][] = 'addressfield_render_address';
    }

    // If cardinality is 1, ensure a label is output for the field by wrapping it
    // in a details element.
    if ($this->fieldDefinition->getFieldCardinality() == 1) {
      $element += array(
        '#type' => 'fieldset',
      );
    }

      return $element;
  }

  public function settingsForm(array $form, array &$form_state) {
    $settings = $this->settings;
    $element = array();

    $element['format_handlers'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Format handlers'),
      '#options' => addressfield_format_plugins_options(),
      '#default_value' => $settings['format_handlers'],
      '#process' => array('form_process_checkboxes', '_addressfield_field_formatter_settings_form_process_add_state'),
      '#element_validate' => array('_addressfield_field_formatter_settings_form_validate')
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();

    $summary = array();

    $plugins = \Drupal::service("plugin.manager.addressfield")->getDefinitions();
    foreach ($settings['format_handlers'] as $handler) {
      $summary[] = $plugins[$handler]['label'];
    }
    if (empty($summary)) {
      $summary[] = t('No handler');
    };

    return $summary;
  }

}
