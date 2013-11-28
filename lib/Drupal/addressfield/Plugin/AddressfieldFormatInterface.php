<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\AddressfieldFormatInterface.
 */

namespace Drupal\addressfield\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;

/**
 * Provides an interface defining a addressfield format plugin.
 */
interface AddressfieldFormatInterface {

  /**
   * Apply formatting to the address.
   *
   * @param array $format
   *   The addressfield widget or formatter array.
   * @param array $address
   *   The addressfield item.
   * @param array $context
   *   Contains additional information about the render process.
   *   - mode: The render mode. 'form' or 'render'
   *   - field: The field definition
   *   - instance: The field instance definition
   *   - delta: The field item delta.
   *   - langcode: The field item language.
   */
  public function format(&$format, $address, $context = array());

}
