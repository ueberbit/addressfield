<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\AddressfieldFormatInterface.
 */

namespace Drupal\addressfield\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Component\Plugin\ConfigurablePluginInterface;

interface AddressfieldFormatInterface {

  /**
   * Enhance addressfield with specific formatting
   *
   * @param array $format
   *   The addressfield widget or formatter array.
   * @param array $address
   *   The addressfield item.
   * @param array $context
   *   Contains additional information about the render process
   *   Known keys:
   *     - 'mode': render mode
   */
  public function format(&$format, $address, $context = array());

}