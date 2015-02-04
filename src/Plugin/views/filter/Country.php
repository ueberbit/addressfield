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
 * Filters addressfield items by country.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsFilter("addressfield_country")
 */
class Country extends InOperator {

  public function getValueOptions() {
    if (!isset($this->value_options)) {
      $this->valueOptions = _addressfield_country_options_list();
    }
    return $this->valueOptions;
  }

}
