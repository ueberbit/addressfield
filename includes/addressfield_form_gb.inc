<?php

/**
 * Address handler for the GB.
 */
class AddressFieldForm_gb implements AddressFieldForm {
  public function form($address, $field, $instance, $langcode, $items, $delta, $element) {
    $required = $delta == 0 && $instance['required'];

    $form['thoroughfare'] = array(
      '#title' => t('Street'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['thoroughfare'],
    );
    $form['premise'] = array(
      '#title' => t('Town'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['premise'],
    );
    $form['locality'] = array(
      '#title' => t('City'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['locality'],
    );
    $form['administrative_area'] = array(
      '#title' => t('County'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['administrative_area'],
      '#required' => $required,
    );
    $form['postal_code'] = array(
      '#title' => t('Post Code'),
      '#type' => 'textfield',
      '#size' => 10,
      '#required' => $required,
      '#default_value' => $address['postal_code'],
    );
    return $form;
  }
}
