<?php

/**
 * @file
 * Hide the country when only one country is available.
 */

$plugin = array(
  'title' => t('Hide the country when only one is available'),
  'format callback' => 'addressfield_format_address_hide_country',
  'type' => 'address',
  'weight' => -80,
);

/**
 * Format callback.
 *
 * @see CALLBACK_addressfield_format_callback()
 */
function addressfield_format_address_hide_country(&$format, $address, $context = array()) {
  if (!empty($format['country']['#options']) && count($format['country']['#options']) == 1) {
    $format['country']['#access'] =  FALSE;
  }
}
