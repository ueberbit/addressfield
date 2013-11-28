<?php

/**
 * @file
 * Contains Drupal\addressfield\Plugin\AddressfieldFormat\AddressHideCountry.
 */

namespace Drupal\addressfield\Plugin\AddressfieldFormat;

use Drupal\addressfield\Plugin\AddressfieldFormatInterface;

/**
 * Hide the country when only one is available.
 *
 * @Plugin(
 *   id = "address_hide_country",
 *   label = @Translation("Hide the country when only one is available")
 * )
 */
class AddressHideCountry implements AddressfieldFormatInterface {

  /**
   * {@inheritdoc}
   */
  public function format(&$format, $address, $context = array()) {
    // When building the format for a form, we expect the country element to have
    // an #options list. If it does, and there is only one option, hide the field
    // by setting #access to FALSE.
    if ($context['mode'] == 'form') {
      if (!empty($format['country']['#options']) && count($format['country']['#options']) == 1) {
        $format['country']['#access'] =  FALSE;
      }
    }
    elseif ($context['mode'] == 'render') {
      // However, in render mode, the element does not have an #options list, so
      // we look instead in the field instance settings if given. If we find a
      // single country option and it matches the country of the current address,
      // go ahead and hide it.
      if (!empty($context['instance']['widget']['settings']['available_countries']) &&
        count($context['instance']['widget']['settings']['available_countries']) == 1) {
        if (isset($context['instance']['widget']['settings']['available_countries'][$address['country']])) {
          $format['country']['#access'] = FALSE;
        }
      }
    }
  }

}
