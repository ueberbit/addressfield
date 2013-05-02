<?php

/**
 * @file
 * API documentation for Addressfield.
 */

/**
 * Format generation callback.
 *
 * @param $format
 *   The address format being generated.
 * @param $address
 *   The address this format is generated for.
 * @param $context
 *   An array of context arguments:
 *     - 'mode': can be either 'form' or 'render'
 *     - (optional) 'field': when generated for a field, the field
 *     - (optional) 'instance': when generated for a field, the field instance
 *     - (optional) 'langcode': when generated for a field, the langcode
 *       this field is being rendered in.
 *     - (optional) 'delta': when generated for a field, the delta of the
 *       currently handled address.
 *
 * @ingroup addressfield_format
 */
function CALLBACK_addressfield_format_callback(&$format, $address, $context = array()) {
  // No example.
}

/**
 * Allows modules to add arbitrary AJAX commands to the array returned from the
 * standard address field widget refresh.
 *
 * @param &$commands
 *   The array of AJAX commands used to refresh the address field widget.
 * @param $form
 *   The rebuilt form array.
 * @param $form_state
 *   The form state array from the form.
 *
 * @see addressfield_standard_widget_refresh()
 */
function hook_addressfield_standard_widget_refresh_alter(&$commands, $form, $form_state) {
  // Display an alert message.
  $commands[] = ajax_command_alert(t('The address field widget has been updated.'));
}
