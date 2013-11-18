<?php

/**
 * @file
 * Contains \Drupal\field\Tests\AddressFieldItemTest.
 */

namespace Drupal\addressfield\Tests;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\field\Tests\FieldUnitTestBase;

/**
 * Tests the new entity API for the addressfield field type.
 */
class AddressFieldItemTest extends FieldUnitTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('addressfield');

  public static function getInfo() {
    return array(
      'name' => 'Addressfield field item',
      'description' => 'Tests the new entity API for the addressfield field type.',
      'group' => 'Field types',
    );
  }

  public function setUp() {
    parent::setUp();

    // Create a addressfield field and instance for validation.
    entity_create('field_entity', array(
      'name' => 'field_test',
      'entity_type' => 'entity_test',
      'type' => 'addressfield',
    ))->save();
    entity_create('field_instance', array(
      'entity_type' => 'entity_test',
      'field_name' => 'field_test',
      'bundle' => 'entity_test',
    ))->save();
  }

  /**
   * Tests using entity fields of the addressfield field type.
   */

  // TODO

  /*public function testTestItem() {
    // Verify entity creation.
    $entity = entity_create('entity_test', array());
    $value = '+0123456789';
    $entity->field_test = $value;
    $entity->name->value = $this->randomName();
    $entity->save();

    // Verify entity has been created properly.
    $id = $entity->id();
    $entity = entity_load('entity_test', $id);
    $this->assertTrue($entity->field_test instanceof FieldItemListInterface, 'Field implements interface.');
    $this->assertTrue($entity->field_test[0] instanceof FieldItemInterface, 'Field item implements interface.');
    $this->assertEqual($entity->field_test->value, $value);
    $this->assertEqual($entity->field_test[0]->value, $value);

    // Verify changing the field value.
    $new_value = '+41' . rand(1000000, 9999999);
    $entity->field_test->value = $new_value;
    $this->assertEqual($entity->field_test->value, $new_value);

    // Read changed entity and assert changed values.
    $entity->save();
    $entity = entity_load('entity_test', $id);
    $this->assertEqual($entity->field_test->value, $new_value);
  }*/

}
