<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\field\formatter\AddressFieldDefaultFormatter.
 */

namespace Drupal\addressfield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'addressfield_default' formatter.
 *
 * @FieldFormatter(
 *   id = "addressfield_default",
 *   label = @Translation("Address Field default"),
 *   field_types = {
 *     "addressfield"
 *   }
 * )
 */
class AddressFieldDefaultFormatter extends FormatterBase {

  /**
   * The AddressfieldFormat plugin Manager.
   *
   * @var \Drupal\addressfield\AddressfieldPluginManager
   */
  protected $addressfieldFormatPluginManager;

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->addressfieldFormatPluginManager = \Drupal::service('plugin.manager.addressfield');
  }

  public static function defaultSettings() {
    $settings = parent::defaultSettings();
    $settings['use_widget_handlers'] = TRUE;
    $settings['format_handlers'] = array(
      'address',
    );
    return $settings;
  }

  protected function getEnabledHandlers() {
    return array_filter($this->getSetting('format_handlers'));
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::settingsForm($form, $form_state);

    $element['use_widget_handlers'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use the same configuration as the widget.'),
      '#default_value' => $this->getSetting('use_widget_handlers'),
    );

    $element['format_handlers'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Format handlers'),
      '#options' => addressfield_format_plugins_options(),
      '#default_value' => $this->getEnabledHandlers(),
      '#element_validate' => array(array(get_class($this), 'validateSettings')),
    );

     return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settings = $this->getSettings();

    $summary = array();

    if ($settings['use_widget_handlers']) {
      $summary[] = t('Use widget configuration');
    }
    else {
      $plugins = \Drupal::service("plugin.manager.addressfield")->getDefinitions();
      foreach ($this->getEnabledHandlers() as $handler) {
        $summary[] = $plugins[$handler]['label'];
      }
      if (empty($summary)) {
        $summary[] = t('No handler');
      };
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = array();

    foreach ($items as $delta => $item) {
      $address = $item->getValue();

      // Generate the address format.
      $context = array(
        'mode' => 'render',
        'field' => $this->fieldDefinition->getName(),
        'instance' => $this->fieldDefinition,
        'delta' => $delta,
        'langcode' => $items->getLangcode(),
      );

      $element[$delta] = addressfield_generate($address, $this->getEnabledHandlers(), $context);
    }

    return $element;
  }

  public static function validateSettings($element, FormStateInterface $form_state, $form) {
    $settings = $form_state->getValue(array_slice($element['#parents'], 0, -1));

    if ($settings['use_widget_handlers'] == TRUE) {
      $settings['format_handlers'] = array();
    }

    $form_state->setValueForElement($element, array_filter($settings['format_handlers']));
  }

}
