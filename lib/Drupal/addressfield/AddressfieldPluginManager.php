<?php
/**
 * Created by PhpStorm.
 * User: meberle
 * Date: 18.11.13
 * Time: 16:38
 */

namespace Drupal\addressfield;


use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Plugin\DefaultPluginManager;

class AddressfieldPluginManager extends DefaultPluginManager {

  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, LanguageManager $language_manager, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/AddressfieldFormat', $namespaces);
    $this->alterInfo($module_handler, 'addressfield_plugin_info');
    $this->setCacheBackend($cache_backend, $language_manager, 'addressfield_plugins');
  }
} 