<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\field\formatter\AddressFieldDefaultFormatter.
 */

namespace Drupal\addressfield\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'addressfield_default' formatter.
 *
 * @FieldFormatter(
 *   id = "addressfield_default",
 *   label = @Translation("Address Field default"),
 *   field_types = {
 *     "addressfield"
 *   },
 *   settings = {
 *     "use_widget_handlers" = "1",
 *     "format_handlers" = {
 *       "address"
 *     }
 *   }
 * )
 */
class AddressFieldDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $settings = $this->settings;
    $element = array();

    $element['use_widget_handlers'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use the same configuration as the widget.'),
      '#default_value' => !empty($settings['use_widget_handlers']),
    );

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

    if ($settings['use_widget_handlers']) {
      $summary[] = t('Use widget configuration');
    }
    else {
      $plugins = \Drupal::service("plugin.manager.addressfield")->getDefinitions();
      foreach ($settings['format_handlers'] as $handler) {
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
  public function viewElements(FieldItemListInterface $items) {
    $element = array();

    foreach ($items as $delta => $item) {
      $element[$delta] = array(
        '#markup' =>
          $item->country . '<br />' .
          $item->administrative_area . '<br />' .
          $item->sub_administrative_area . '<br />' .
          $item->locality . '<br />' .
          $item->dependent_locality . '<br />' .
          $item->postal_code . '<br />' .
          $item->thoroughfare . '<br />' .
          $item->premise . '<br />' .
          $item->sub_premise . '<br />' .
          $item->organisation_name . '<br />' .
          $item->name_line . '<br />' .
          $item->first_name . '<br />' .
          $item->last_name . '<br />' .
          $item->data,
      );
    }

    return $element;
  }
}
