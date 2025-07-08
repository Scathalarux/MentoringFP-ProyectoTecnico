<?php

namespace Drupal\fractionslider\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * @Block(
 *   id = "fractionslider_configurable_text",
 *   admin_label = @Translation("Fractionslider Block")
 * )
 */
class FractionsliderConfigurableTextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    $path = '/' . \Drupal::service('extension.list.module')->getPath('fractionslider');

    $slider = '<div class="slider-wrapper">
  <div class="responisve-container">
    <div class="slider">
      <div class="fs_loader"></div>
      <div class="slide"> <img src="' . $path . '/images/01_box_top.png" width="361" height="354" data-position="-152,142" data-in="left" data-delay="200" data-out="right"> <img src="' . $path . '/images/01_box_bottom.png"  width="422" height="454"  data-position="138,-152" data-in="bottomRight" data-delay="200"> <img src="' . $path . '/images/01_waves.png"  width="1449" height="115" data-position="240,17" data-in="left" data-delay="" data-out="left"> <img src="' . $path . '/images/01_outofthebox.png"  data-position="20,330" data-in="bottomLeft" data-delay="500" data-out="fade" style="width:auto; height:auto">
        <p data-ease-in="easeOutBounce" data-out="top" data-time="1000" data-step="1" data-in="top" data-position="20,30" class="claim light-green" rel="0">jQuery FractionSlider</p>
        <p class="teaser orange" data-position="90,30" data-in="left" data-step="2" data-delay="500">animate multiple elements</p>
        <p class="teaser green" data-position="90,30" data-in="left" data-step="2" data-special="cycle" data-delay="3000">full control over each element</p>
        <p class="teaser turky" data-position="90,30" data-in="left" data-step="2" data-special="cycle" data-delay="5500" data-out="none">opensource and free</p>
      </div>
      <div class="slide" data-in="slideLeft"> <img src="' . $path . '/images/02_big_boxes.png"  data-fixed data-position="25,445" data-in="fade" data-delay="0" data-out="right"> <img src="' . $path . '/images/02_small_boxes.png" data-position="80,220" data-in="fade" data-delay="500" data-out="bottomRight"> <img src="' . $path . '/images/01_box_bottom.png"  data-position="138,-152" data-in="bottomRight" data-delay="200" data-out="bottomRight">
        <p class="claim light-green small"  data-position="30,30" data-in="top" data-step="1" data-out="top">What to expect</p>
        <p class="teaser turky small" data-position="90,30" data-in="bottom" data-step="2" data-delay="500">unlimited elements</p>
        <p class="teaser turky small" data-position="120,30" data-in="bottom" data-step="2" data-delay="1500">many transitions</p>
        <p class="teaser turky small" data-position="150,30" data-in="bottom" data-step="2" data-delay="2500">unlimited slides</p>
        <p class="teaser turky small" data-position="180,30" data-in="bottom" data-step="2" data-delay="3500">background animation</p>
        <p class="teaser turky small" data-position="210,30" data-in="bottom" data-step="2" data-delay="4500">easy to use</p>
      </div>
    </div>
  </div>
</div>';
    return [
      'fractionslider_string' => $slider,
      'fractionslider_dimensions' => '1000, 400',
      'fractionslider_controls' => 'true',
      'fractionslider_pager' => 'true',
      'fractionslider_fullwidth' => 'true',
      'fractionslider_responsive' => 'true',
      'fractionslider_pausehover' => 'true',
      'fractionslider_increase' => 'true',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['fractionslider_string_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('FractionSlider HTML'),
      '#rows' => 25,
      '#description' => $this->t('This is what HTML structure for FractionSlider. Change elements/text under < div class="slide"> to see changes.'),
      '#default_value' => $this->configuration['fractionslider_string'],
    ];
    $form['fractionslider_controls'] = [
      '#type' => 'select',
      '#title' => $this->t('Controls'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $this->configuration['fractionslider_controls'],
      '#description' => $this->t('Controls on/off'),
    ];

    $form['fractionslider_pager'] = [
      '#type' => 'select',
      '#title' => $this->t('Pager'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $this->configuration['fractionslider_pager'],
      '#description' => $this->t("Pager inside of the slider on/off."),
    ];
    $form['fractionslider_dimensions'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dimensions'),
      '#default_value' => $this->configuration['fractionslider_dimensions'],
      '#description' => $this->t('Default: 1000, 400'),
    ];
    $form['fractionslider_fullwidth'] = [
      '#type' => 'select',
      '#title' => $this->t('Full width'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $this->configuration['fractionslider_fullwidth'],
      '#description' => $this->t('Default: false'),
    ];
    $form['fractionslider_responsive'] = [
      '#type' => 'select',
      '#title' => $this->t('Responsive'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $this->configuration['fractionslider_responsive'],
      '#description' => $this->t('Default: true'),
    ];
    $form['fractionslider_pausehover'] = [
      '#type' => 'select',
      '#title' => $this->t('Pause on Hover'),
      '#options' => [
        'false' => $this->t('False'),
        'true' => $this->t('True'),
      ],
      '#default_value' => $this->configuration['fractionslider_pausehover'],
      '#description' => $this->t('Default: false'),
    ];
    $form['fractionslider_increase'] = [
      '#type' => 'select',
      '#title' => $this->t('Increase'),
      '#options' => [
        'true' => $this->t('True'),
        'false' => $this->t('False'),
      ],
      '#default_value' => $this->configuration['fractionslider_increase'],
      '#description' => $this->t('Default: false'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getCompleteFormState()->getValues();
    $this->setConfiguration($values['settings']);
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $settings = $this->configuration;
    unset($settings['fractionslider_string']);

    return [
      '#theme' => 'fractionslider_block',
      '#data' => $this->configuration,
      '#attached' => [
        'drupalSettings' => [
          'fractionslider' => $settings,
        ],
      ]
    ];
  }

}
