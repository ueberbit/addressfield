<?php

/**
 * Address handler for Brazil.
 */
class AddressFieldForm_br implements AddressFieldForm {
  public function form($address, $field, $instance, $langcode, $items, $delta, $element) {
    $required = $delta == 0 && $instance['required'];

    $form['thoroughfare'] = array(
      '#title' => t('Address'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['thoroughfare'],
    );
    $form['premise'] = array(
      '#title' => t('Number'),
      '#type' => 'textfield',
      '#size' => 10,
      '#required' => $required,
      '#default_value' => $address['premise'],
    );
    $form['sub_premise'] = array(
      '#title' => t('Complement'),
      '#type' => 'textfield',
      '#size' => 30,
      '#default_value' => $address['sub_premise'],
    );
    $form['dependent_locality'] = array(
      '#title' => t('Neighborhood'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['dependent_locality'],
    );
    $form['locality'] = array(
      '#title' => t('City'),
      '#type' => 'textfield',
      '#size' => 30,
      '#required' => $required,
      '#default_value' => $address['locality'],
    );
    $form['administrative_area'] = array(
      '#title' => t('State'),
      '#type' => 'select',
      '#default_value' => $address['administrative_area'],
      '#required' => $required,
      '#options' => array(
        ''   => t('--'),
        'AC' => t('Acre'),
        'AL' => t('Alagoas'),
        'AM' => t('Amazonas'),
        'AP' => t('Amapa'),
        'BA' => t('Bahia'),
        'CE' => t('Ceara'),
        'DF' => t('Distrito Federal'),
        'ES' => t('Espirito Santo'),
        'GO' => t('Goias'),
        'MA' => t('Maranhao'),
        'MG' => t('Minas Gerais'),
        'MS' => t('Mato Grosso do Sul'),
        'MT' => t('Mato Grosso'),
        'PA' => t('Para'),
        'PB' => t('Paraiba'),
        'PE' => t('Pernambuco'),
        'PI' => t('Piaui'),
        'PR' => t('Parana'),
        'RJ' => t('Rio de Janeiro'),
        'RN' => t('Rio Grande do Norte'),
        'RO' => t('Rondonia'),
        'RR' => t('Roraima'),
        'RS' => t('Rio Grande do Sul'),
        'SC' => t('Santa Catarina'),
        'SE' => t('Sergipe'),
        'SP' => t('Sao Paulo'),
        'TO' => t('Tocantins'),
      ),
    );
    $form['postal_code'] = array(
      '#title' => t('Postal code'),
      '#type' => 'textfield',
      '#size' => 10,
      '#required' => $required,
      '#default_value' => $address['postal_code'],
    );
    return $form;
  }
}
