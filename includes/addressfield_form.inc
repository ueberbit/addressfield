<?php

/**
 * Interface for an address field form.
 */
interface AddressFieldForm {

  /**
   * Return the edit form for a given address.
   */
  public function form($address, $field, $instance, $langcode, $items, $delta, $element);

}
