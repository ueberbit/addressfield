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
 *   default_widget = "addressfield_simple",
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
        'label' => t('Administrative area'),
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
}