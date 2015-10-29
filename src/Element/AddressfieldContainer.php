<?php
/**
 * @file
 * Contains \Drupal\addressfield\Element\AddressfieldContainer.
 */

namespace Drupal\addressfield\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a grouping container for the different address input fields.
 *
 * @RenderElement("addressfield_container")
 */
class AddressfieldContainer extends RenderElement {

  public function getInfo() {
    $class = get_class($this);
    return array(
      '#process' => array(array($class, 'processAddressfieldContainer')),
      '#theme_wrappers' => array('addressfield_container'),
      '#attributes' => array(),
      '#tag' => 'div',
    );
  }

  /**
   * Form API process function: set the #parents of the children of this element so they appear at the same level as the parent.
   *
   * @param array $element
   *   An associative array containing the properties and children of the
   *   container.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param array $complete_form
   *   The complete form structure.
   *
   * @return array
   *   The processed element.
   */
  public static function processAddressfieldContainer(&$element, FormStateInterface $form_state, &$complete_form) {
    foreach (Element::children($element) as $key) {
      $element[$key]['#parents'] = $element['#parents'];
      $element[$key]['#parents'][count($element[$key]['#parents']) - 1] = $key;
    }
    return $element;
  }

}
