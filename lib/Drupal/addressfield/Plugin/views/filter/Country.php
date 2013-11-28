<?php

/**
 * @file
 * Definition of Drupal\addressfield\Plugin\views\field\Country.
 */

namespace Drupal\addressfield\Plugin\views\filter;

use Drupal\Component\Annotation\PluginID;
use Drupal\Component\Utility\String;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\Plugin\views\filter\FilterPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ResultRow;

/**
 * foo.
 *
 * @ingroup views_field_handlers
 *
 * @PluginID("addressfield_country")
 */
class Country extends InOperator {

  public function getValueOptions() {
    if (!isset($this->value_options)) {
      $this->value_options = _addressfield_country_options_list();
    }
    return $this->value_options;
  }

}
