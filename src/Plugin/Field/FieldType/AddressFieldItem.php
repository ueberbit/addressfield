<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\Field\FieldType\AddressFieldItem.
 */

namespace Drupal\addressfield\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\MapDataDefinition;

/**
 * Plugin implementation of the 'addressfield' field type.
 *
 * @FieldType(
 *   id = "addressfield",
 *   label = @Translation("Postal address"),
 *   description = @Translation("A field type used for storing postal addresses according the xNAL standard."),
 *   default_widget = "addressfield_standard",
 *   default_formatter = "addressfield_default"
 * )
 */
class AddressFieldItem extends FieldItemBase {

  public static function defaultFieldSettings() {
    $settings = parent::defaultFieldSettings();
    $settings['available_countries'] = array();
    return $settings;
  }

  /**
   * Definitions of the contained properties.
   *
   * @var array
   */
  static $propertyDefinitions;
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'country' => array(
          'description' => 'Two letter ISO country code of this address.',
          'type' => 'varchar',
          'length' => 2,
          'not null' => FALSE,
          'default' => '',
        ),
        'administrative_area' => array(
          'description' => 'The administrative area of this address. (i.e. State/Province)',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'sub_administrative_area' => array(
          'description' => 'The sub administrative area of this address.',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'locality' => array(
          'description' => 'The locality of this address. (i.e. City)',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'dependent_locality' => array(
          'description' => 'The dependent locality of this address.',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'postal_code' => array(
          'description' => 'The postal code of this address.',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'thoroughfare' => array(
          'description' => 'The thoroughfare of this address. (i.e. Street address)',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'premise' => array(
          'description' => 'The premise of this address. (i.e. Apartment / Suite number)',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'sub_premise' => array(
          'description' => 'The sub_premise of this address.',
          'type' => 'varchar',
          'length' => 255,
          'default' => '',
          'not null' => FALSE,
        ),
        'organisation_name' => array(
          'description' => 'Contents of a primary OrganisationName element in the xNL XML.',
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
          'default' => '',
        ),
        'name_line' => array(
          'description' => 'Contents of a primary NameLine element in the xNL XML.',
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
          'default' => '',
        ),
        'first_name' => array(
          'description' => 'Contents of the FirstName element of a primary PersonName element in the xNL XML.',
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
          'default' => '',
        ),
        'last_name' => array(
          'description' => 'Contents of the LastName element of a primary PersonName element in the xNL XML.',
          'type' => 'varchar',
          'length' => 255,
          'not null' => FALSE,
          'default' => '',
        ),
        'data' => array(
          'description' => 'Additional data for this address.',
          'type' => 'text',
          'size' => 'big',
          'not null' => FALSE,
          'serialize' => TRUE,
        ),

        // TODO Add indexes.

      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['country'] = DataDefinition::create('string')
      ->setLabel(t('Country'));

    $properties['administrative_area'] = DataDefinition::create('string')
      ->setLabel(t('Administrative area (i.e. State / Province)'));

    $properties['sub_administrative_area'] = DataDefinition::create('string')
      ->setLabel(t('Sub administrative area'));

    $properties['locality'] = DataDefinition::create('string')
      ->setLabel(t('Locality (i.e. City)'));

    $properties['dependent_locality'] = DataDefinition::create('string')
      ->setLabel(t('Dependent locality'));

    $properties['postal_code'] = DataDefinition::create('string')
      ->setLabel(t('Postal code'));

    $properties['thoroughfare'] = DataDefinition::create('string')
      ->setLabel(t('Thoroughfare (i.e. Street address)'));

    $properties['premise'] = DataDefinition::create('string')
      ->setLabel(t('Administrative area (i.e. State / Province)'));

    $properties['sub_premise'] = DataDefinition::create('string')
      ->setLabel(t('Premise (i.e. Apartment / Suite number)'));

    $properties['organisation_name'] = DataDefinition::create('string')
      ->setLabel(t('Organisation name'));

    $properties['name_line'] = DataDefinition::create('string')
      ->setLabel(t('Full name'));

    $properties['first_name'] = DataDefinition::create('string')
      ->setLabel(t('First name'));

    $properties['last_name'] = DataDefinition::create('string')
      ->setLabel(t('Last name'));

    $properties['data'] = MapDataDefinition::create()
      ->setLabel(t('Additional data for this address'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    // Get base form from FileItem::instanceSettingsForm().
    $element = parent::fieldSettingsForm($form, $form_state);

    /**
     * @var \Drupal\Core\Locale\CountryManagerInterface $country_manager
     */
    $country_manager = \Drupal::service('country_manager');
    $countries = $country_manager->getList();

    $element['available_countries'] = array(
      '#type' => 'select',
      '#multiple' => TRUE,
      '#title' => t('Available countries'),
      '#description' => t('If no countries are selected, all countries will be available.'),
      '#options' => $countries,
      '#default_value' => $this->getSetting('available_countries'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    // Every address field must have at least a country value or it is considered
    // empty, even if it has name information.
    $value = $this->get('country')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function preSave() {
    $item = $this->toArray();

    // If the first name and last name are set but the name line isn't...
    if (isset($item['first_name']) && isset($item['last_name']) && !isset($item['name_line'])) {
      // Combine the first and last name to be the name line.
      $this->set('name_line', $item['first_name'] . ' ' . $item['last_name']);
    }
    elseif (isset($item['name_line'])) {
      // Otherwise if the name line is set, separate it out into a best guess at
      // the first and last name.
      $names = explode(' ', $item['name_line']);

      $this->set('first_name', array_shift($names));
      $this->set('last_name', implode(' ', $names));
    }

    // Trim whitespace from all of the address components and convert any double
    // spaces to single spaces.
    foreach ($this->toArray() as $key => $value) {
      if (!in_array($key, array('data')) && is_string($value)) {
        $this->set($key, trim(str_replace('  ', ' ', $value)));
      }
    }
  }
}
