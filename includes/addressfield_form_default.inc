<?php

/**
 * Default address handler.
 */
class AddressFieldForm_default implements AddressFieldForm {
  public function form($address, $field, $instance, $langcode, $items, $delta, $element) {
    $required = $delta == 0 && $instance['required'];

    $form['thoroughfare'] = array(
      '#title' => t('Street'),
      '#type' => 'textfield',
      '#required' => $required,
      '#size' => 30,
      '#default_value' => $address['thoroughfare'],
    );
    $form['premise'] = array(
      '#title' => t('Residence, building, ...'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['premise'],
    );
    $form['sub_premise'] = array(
      '#title' => t('Floor, stairway, ...'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['sub_premise'],
    );
    $form['dependent_locality'] = array(
      '#title' => t('Suburb, post box, ...'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['dependent_locality'],
    );
    $form['postal_code'] = array(
      '#title' => t('Postal Code'),
      '#type' => 'textfield',
      '#size' => 10,
      '#required' => $required,
      '#default_value' => $address['postal_code'],
    );
    $form['locality'] = array(
      '#title' => t('City'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['locality'],
    );

    // All the other fields are unsupported by this handler.
    foreach (array('administrative_area', 'sub_administrative_area') as $field) {
      $form[$field] = array(
        '#type' => 'value',
        '#value' => '',
      );
    }
    return $form;
  }
}
