<?php

/**
 * @file
 * Contains \Drupal\addressfield\Plugin\Field\FieldType\AddressFieldItem.
 */

namespace Drupal\addressfield\Plugin\Field\FieldType;

use Drupal\Core\Field\ConfigFieldItemBase;
use Drupal\Field\FieldInterface;

/**
 * Plugin implementation of the 'addressfield' field type.
 *
 * @FieldType(
 *   id = "addressfield",
 *   label = @Translation("Postal address"),
 *   description = @Translation("A field type used for storing postal addresses according the xNAL standard."),
 *   default_widget = "addressfield_standard",
 *   default_formatter = "addressfield_default",
 *   instance_settings = {
 *     "available_countries" = "",
 *   }
 * )
 */
class AddressFieldItem extends ConfigFieldItemBase {
  /**
   * Definitions of the contained properties.
   *
   * @var array
   */
  static $propertyDefinitions;
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldInterface $field) {
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
  public function getPropertyDefinitions() {
    if (!isset(static::$propertyDefinitions)) {
      static::$propertyDefinitions['country'] = array(
        'type' => 'string',
        'label' => t('Country'),
      );
      static::$propertyDefinitions['administrative_area'] = array(
        'type' => 'string',
        'label' => t('Administrative area (i.e. State / Province)'),
      );
      static::$propertyDefinitions['sub_administrative_area'] = array(
        'type' => 'string',
        'label' => t('Sub administrative area'),
      );
      static::$propertyDefinitions['locality'] = array(
        'type' => 'string',
        'label' => t('Locality (i.e. City)'),
      );
      static::$propertyDefinitions['dependent_locality'] = array(
        'type' => 'string',
        'label' => t('Dependent locality'),
      );
      static::$propertyDefinitions['postal_code'] = array(
        'type' => 'string',
        'label' => t('Postal code'),
      );
      static::$propertyDefinitions['thoroughfare'] = array(
        'type' => 'string',
        'label' =>  t('Thoroughfare (i.e. Street address)'),
      );
      static::$propertyDefinitions['premise'] = array(
        'type' => 'string',
        'label' => t('Administrative area (i.e. State / Province)'),
      );
      static::$propertyDefinitions['sub_premise'] = array(
        'type' => 'string',
        'label' => t('Premise (i.e. Apartment / Suite number)'),
      );
      static::$propertyDefinitions['organisation_name'] = array(
        'type' => 'string',
        'label' => t('Organisation name'),
      );
      static::$propertyDefinitions['name_line'] = array(
        'type' => 'string',
        'label' => t('Full name'),
      );
      static::$propertyDefinitions['first_name'] = array(
        'type' => 'string',
        'label' => t('First name'),
      );
      static::$propertyDefinitions['last_name'] = array(
        'type' => 'string',
        'label' => t('Last name'),
      );
    }
    return static::$propertyDefinitions;
  }

  /**
   * {@inheritdoc}
   */
  public function instanceSettingsForm(array $form, array &$form_state) {
    // Get base form from FileItem::instanceSettingsForm().
    $element = parent::instanceSettingsForm($form, $form_state);

    $settings = $this->getFieldSettings();

    /**
     * @var Drupal\Core\Locale\CountryManagerInterface $country_manager
     */
    $country_manager = \Drupal::service('country_manager');

    $countries = $country_manager->getList();

    $element['available_countries'] = array(
      '#type' => 'select',
      '#multiple' => TRUE,
      '#title' => t('Available countries'),
      '#description' => t('If no countries are selected, all countries will be available.'),
      '#options' => $countries,
      '#default_value' => $settings['available_countries'],
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
    $item = $this->getPropertyValues();

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
    foreach ($this->getPropertyValues() as $key => $value) {
      if (!in_array($key, array('data')) && is_string($value)) {
        $this->set($key, trim(str_replace('  ', ' ', $value)));
      }
    }
  }
}
