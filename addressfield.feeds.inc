<?php

/**
 * @file
 * Integration with the Feeds module.
 */

/**
 * Implements hook_feeds_node_processor_targets_alter().
 */
function addressfield_feeds_processor_targets_alter(&$targets, $entity_type, $bundle_name) {
  foreach (field_info_instances($entity_type, $bundle_name) as $name => $instance) {
    $info = field_info_field($name);
    if ($info['type'] == 'addressfield') {
      foreach ($info['columns'] as $sub_field => $schema_info) {
        $name_label = $instance['label'] . ': ' . drupal_ucfirst(str_replace('_', ' ', $sub_field));
        $targets[$name . ':' . $sub_field] = array(
          'name' => $name_label,
          'callback' => 'addressfield_set_target',
          'real_target' => $info['field_name'],
          'description' => $schema_info['description'],
        );
      }
    }
  }
}

/**
 * Callback for hook_feeds_processor_targets_alter().
 *
 * @param $source
 *   Field mapper source settings.
 * @param $entity
 *   An entity object, for instance a node object.
 * @param $target
 *   A string identifying the target on the node.
 * @param $value
 *   The value to populate the target with.
 */
function addressfield_set_target($source, $entity, $target, $values) {
  list($field_name, $sub_field) = explode(':', $target, 2);

  // Convert the values into an array if it isn't one already to correspond to
  // Drupal's handling of field value arrays.
  if (!is_array($values)) {
    $values = array($values);
  }

  // If the field is already set on the given entity, update the existing value
  // array. Otherwise start with a fresh field value array.
  $field = isset($entity->$field_name) ? $entity->$field_name : array();

  // Determine the language code to use for the import. First we have to find
  // the entity type based on the processor specified in the importer config
  // array, and then we make use of the API function added in Drupal 7.15.
  $langcode = NULL;
  $config = $source->importer->getConfig();

  ctools_include('plugins');
  if ($class = ctools_plugin_load_class('feeds', 'plugins', $config['processor']['plugin_key'], 'handler')) {
    if (method_exists($class, 'entityType')) {
      $entity_type = $class::entityType();
      $langcode = entity_language($entity_type, $entity);
    }
  }

  if (empty($langcode)) {
    $langcode = LANGUAGE_NONE;
  }

  // Loop over the field values array...
  foreach ($values as $delta => $value) {
    $field[$langcode][$delta][$sub_field] = $value;
  }

  $entity->$field_name = $field;
}
