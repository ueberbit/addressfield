<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\Field\FieldWidget\AddressFieldSimpleWidget.
 */

namespace Drupal\addressfield\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;

/**
 * Plugin implementation of the 'addressfield_simple' widget.
 *
 * @FieldWidget(
 *   id = "addressfield_simple",
 *   label = @Translation("Addressfield Simple Widget"),
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
class AddressFieldSimpleWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, array &$form_state) {
    // Determine the list of available countries, and if the currently selected
    // country is not in it, unset it so it can be reset to the default country.

    $countries = _addressfield_country_options_list($this->fieldDefinition->getField(), $this->fieldDefinition);

    $element['country'] = array(
      '#type' => 'select',
      '#title' => t('Country'),
      '#options' => $countries,
      '#default_value' => isset($items[$delta]->country) ? $items[$delta]->country : NULL,
    );
    $element['administrative_area'] = array(
      '#type' => 'textfield',
      '#title' => t('Administrative area (i.e. State / Province)'),
      '#default_value' => isset($items[$delta]->administrative_area) ? $items[$delta]->administrative_area : NULL,
    );
    $element['sub_administrative_area'] = array(
      '#type' => 'textfield',
      '#title' => t('Sub administrative area'),
      '#default_value' => isset($items[$delta]->sub_administrative_area) ? $items[$delta]->sub_administrative_area : NULL,
    );
    $element['locality'] = array(
      '#type' => 'textfield',
      '#title' => t('Locality (i.e. City)'),
      '#default_value' => isset($items[$delta]->locality) ? $items[$delta]->locality : NULL,
    );
    $element['dependent_locality'] = array(
      '#type' => 'textfield',
      '#title' => t('Dependent locality'),
      '#default_value' => isset($items[$delta]->dependent_locality) ? $items[$delta]->dependent_locality : NULL,
    );
    $element['postal_code'] = array(
      '#type' => 'textfield',
      '#title' => t('Postal code'),
      '#default_value' => isset($items[$delta]->postal_code) ? $items[$delta]->postal_code : NULL,
    );
    $element['thoroughfare'] = array(
      '#type' => 'textfield',
      '#title' => t('Thoroughfare (i.e. Street address)'),
      '#default_value' => isset($items[$delta]->thoroughfare) ? $items[$delta]->thoroughfare : NULL,
    );
    $element['premise'] = array(
      '#type' => 'textfield',
      '#title' => t('Premise (i.e. Apartment / Suite number)'),
      '#default_value' => isset($items[$delta]->premise) ? $items[$delta]->premise : NULL,
    );
    $element['sub_premise'] = array(
      '#type' => 'textfield',
      '#title' => t('Sub premise'),
      '#default_value' => isset($items[$delta]->sub_premise) ? $items[$delta]->sub_premise : NULL,
    );
    $element['organisation_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Organisation name'),
      '#default_value' => isset($items[$delta]->organisation_name) ? $items[$delta]->organisation_name : NULL,
    );
    $element['name_line'] = array(
      '#type' => 'textfield',
      '#title' => t('Full name'),
      '#default_value' => isset($items[$delta]->name_line) ? $items[$delta]->name_line : NULL,
    );
    $element['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First name'),
      '#default_value' => isset($items[$delta]->first_name) ? $items[$delta]->first_name : NULL,
    );
    $element['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last name'),
      '#default_value' => isset($items[$delta]->last_name) ? $items[$delta]->last_name : NULL,
    );
    $element['data'] = array(
      '#type' => 'textfield',
      '#title' => t('Additional Data'),
      '#default_value' => isset($items[$delta]->data) ? $items[$delta]->data : NULL,
    );

    // If cardinality is 1, ensure a label is output for the field by wrapping it
    // in a details element.
    if ($this->fieldDefinition->getFieldCardinality() == 1) {
      $element += array(
        '#type' => 'fieldset',
      );
    }

    return $element;
  }

}
