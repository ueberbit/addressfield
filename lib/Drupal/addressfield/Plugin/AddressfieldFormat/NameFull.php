<?php

/**
 * @file
 * Contains Drupal\addressfield\Plugin\AddressfieldFormat\NameFull.
 */

namespace Drupal\addressfield\Plugin\AddressfieldFormat;

use Drupal\addressfield\Plugin\AddressfieldFormatInterface;

/**
 * Name (First name, Last name)
 *
 * @Plugin(
 *   id = "name_full",
 *   label = @Translation("Name (First name, Last name)")
 * )
 */
class NameFull implements AddressfieldFormatInterface {

  /**
   * {@inheritdoc}
   */
  public function format(&$format, $address, $context = array()) {
    $format['name_block'] = array(
      '#type' => 'addressfield_container',
      '#attributes' => array('class' => array('addressfield-container-inline', 'name-block')),
      '#weight' => -100,
    );
    $format['name_block']['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First name'),
      '#size' => 30,
      '#required' => TRUE,
      '#attributes' => array('class' => array('first-name')),
    );
    $format['name_block']['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last name'),
      '#size' => 30,
      '#required' => TRUE,
      '#prefix' => ' ',
      '#attributes' => array('class' => array('last-name')),
    );
  }

}
