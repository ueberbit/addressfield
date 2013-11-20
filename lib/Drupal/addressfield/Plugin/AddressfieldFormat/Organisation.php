<?php

namespace Drupal\addressfield\Plugin\AddressfieldFormat;
use Drupal\addressfield\Plugin\AddressfieldFormatInterface;

/**
 * Organisation (single line)
 *
 * @Plugin(
 *   id = "organisation",
 *   label = @Translation("Organisation (single line)")
 * )
 */
class Organisation implements AddressfieldFormatInterface {

  public function format(&$format, $address, $context = array()) {
    $format['organisation_block'] = array(
      '#type' => 'addressfield_container',
      '#attributes' => array('class' => array('addressfield-container-inline', 'name-block')),
      '#weight' => -50,
    );
    $format['organisation_block']['organisation_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Company'),
      '#size' => 30,
      '#attributes' => array('class' => array('organisation-name')),
    );
  }

}
