<?php

/**
 * @file
 * Definition of Drupal\addressfield\Plugin\views\field\AddressfieldCountry.
 */

namespace Drupal\addressfield\Plugin\views\field;

use Drupal\Component\Annotation\PluginID;
use Drupal\Component\Utility\String;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Defines a field handler that can display the country name instead of the two
 * character country code for an address field country value.
 *
 * @ingroup views_field_handlers
 *
 * @PluginID("addressfield_country")
 */
class Country extends FieldPluginBase {

  /**
   * @var array Stores the available options.
   */
  protected $valueOptions;

  /**
   * Get available options.
   *
   * @return array
   */
  public function getValueOptions() {
    if (!isset($this->valueOptions)) {
      $this->valueOptions = _addressfield_country_options_list();
    }
    return $this->valueOptions;
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['display_name'] = array('default' => TRUE, 'bool' => TRUE);
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, &$form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['display_name'] = array(
      '#title' => t('Display name'),
      '#description' => t('Display the localized country name instead of the two character country code.'),
      '#type' => 'checkbox',
      '#default_value' => !empty($this->options['display_name']),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function preRender(&$values) {
    $this->getValueOptions();
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $value = $values->{$this->field_alias};
    if (!empty($this->options['display_name']) && isset($this->valueOptions[$value])) {
      $result = $this->valueOptions[$value];
    }
    else {
      $result = $value;
    }

    return String::checkPlain($result);
  }

}
