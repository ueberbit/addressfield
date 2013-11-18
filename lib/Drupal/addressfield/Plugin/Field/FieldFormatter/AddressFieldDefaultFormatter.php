<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\field\formatter\AddressFieldDefaultFormatter.
 */

namespace Drupal\addressfield\Plugin\Field\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'addressfield_default' formatter.
 *
 * @FieldFormatter(
 *   id = "addressfield_default",
 *   label = @Translation("Address Field default"),
 *   field_types = {
 *     "addressfield"
 *   }
 * )
 */

class AddressFieldDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {
    $element = array();

    foreach ($items as $delta => $item) {
      $element[$delta] = array(
        '#markup' =>
          $item->country . '<br />' .
          $item->administrative_area . '<br />' .
          $item->sub_administrative_area . '<br />' .
          $item->locality . '<br />' .
          $item->dependent_locality . '<br />' .
          $item->postal_code . '<br />' .
          $item->thoroughfare . '<br />' .
          $item->premise . '<br />' .
          $item->sub_premise . '<br />' .
          $item->organisation_name . '<br />' .
          $item->name_line . '<br />' .
          $item->first_name . '<br />' .
          $item->last_name . '<br />' .
          $item->data,
      );
    }

    return $element;
  }
}
