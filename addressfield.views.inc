<?php

/**
 * Implements hook_field_views_data().
 */
function addressfield_field_views_data($field) {
  $data = views_field_default_views_data($field);

  // Only expose these components as Views field handlers.
  $implemented = array(
    'country' => 'addressfield_country',
    'administrative_area' => 'standard',
    'locality' => 'standard',
    'postal_code' => 'standard',
    'thoroughfare' => 'standard',
    'premise' => 'standard',
    'organisation_name' => 'standard',
    'name_line' => 'standard',
    'first_name' => 'standard',
    'last_name' => 'standard',
  );


  foreach ($data as $table_name => $table_data) {
    foreach ($implemented as $property => $plugin_id) {
      $data[$table_name][$field->getName() . '_' . $property]['field'] = array(
        'id' => $plugin_id,
      );
    }

    $data[$table_name][$field->getName() . '_country']['filter']['id'] = 'addressfield_country';
  }

  return $data;
}
