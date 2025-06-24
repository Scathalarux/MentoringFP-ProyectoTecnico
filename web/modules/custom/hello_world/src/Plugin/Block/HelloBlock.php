<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provides a 'Hello' Block.
 */

#[Block(
  id: "hello_block",
  admin_label: new TranslatableMarkup("Hello block"),
  category: new TranslatableMarkup("Hello World"),
)]

class HelloBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Hola Mundo! Muchas gracias por acceder a la web!'),
    ];
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

