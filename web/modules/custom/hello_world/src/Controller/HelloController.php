<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\hello_world\Controller;

class HelloController {

  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world!'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('hello_world.settings');
    return [
      'hello_block_name' => $default_config->get('hello.name'),
    ];
  }


}

