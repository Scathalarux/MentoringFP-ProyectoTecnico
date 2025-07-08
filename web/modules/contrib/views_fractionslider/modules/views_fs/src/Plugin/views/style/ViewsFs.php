<?php

namespace Drupal\views_fs\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin to render a Fractionslider.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "views_fs",
 *   title = @Translation("Views Fractionslider"),
 *   help = @Translation("Render a Fractionslider."),
 *   theme = "views_view_views_fs",
 *   display_types = { "normal" }
 * )
 */
class ViewsFs extends StylePluginBase {

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesFields = TRUE;

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state): void {
    parent::buildOptionsForm($form, $form_state);

    $form['general_settings'] = [
      '#type' => 'details',
      '#title' => t('General Settings'),
      '#open' => TRUE,
    ];
    $form['class'] = [
      '#title' => t('Div class'),
      '#description' => t('The class to provide on the Div element itself. In addition with "slide" class.'),
      '#type' => 'textfield',
      '#size' => '30',
      '#default_value' => $this->options['class'] ?? '',
      '#fieldset' => 'general_settings',
    ];
    $form['pager'] = [
      '#type' => 'select',
      '#title' => t('Pager'),
      '#options' => [
        'true' => t('True'),
        'false' => t('False'),
      ],
      '#default_value' => $this->options['pager'] ?? 'true',
      '#description' => t('Set Pager True or False. Default is True.'),
      '#fieldset' => 'general_settings',
    ];
    $form['controls'] = [
      '#type' => 'select',
      '#title' => t('Controls'),
      '#options' => [
        'true' => t('True'),
        'false' => t('False'),
      ],
      '#default_value' => $this->options['controls'] ?? 'true',
      '#description' => t('Set Controls True or False. Default is True.'),
      '#fieldset' => 'general_settings',
    ];
    $form['views_dimensions'] = [
      '#type' => 'textfield',
      '#title' => t('Dimensions'),
      '#default_value' => $this->options['views_dimensions'] ?? '1000, 400',
      '#description' => t('Default: 1000, 400'),
      '#fieldset' => 'general_settings',
    ];
    $form['views_fullwidth'] = [
      '#type' => 'select',
      '#title' => t('Full width'),
      '#options' => [
        'false' => t('False'),
        'true' => t('True'),
      ],
      '#default_value' => $this->options['views_fullwidth'] ?? 'false',
      '#description' => t('Transition over the full width of the window. Default: false'),
      '#fieldset' => 'general_settings',
    ];
    $form['views_responsive'] = [
      '#type' => 'select',
      '#title' => t('Responsive'),
      '#options' => [
        'false' => t('False'),
        'true' => t('True'),
      ],
      '#default_value' => $this->options['views_responsive'] ?? 'true',
      '#description' => t('Default: true'),
      '#fieldset' => 'general_settings',
    ];
    $form['views_increase'] = [
      '#type' => 'select',
      '#title' => t('Increase'),
      '#options' => [
        'false' => t('False'),
        'true' => t('True'),
      ],
      '#default_value' => $this->options['views_increase'] ?? 'true',
      '#description' => t('If set, slider is allowed to get bigger than basic dimensions. Default: false'),
      '#fieldset' => 'general_settings',
    ];
    $form['fields_settings'] = [
      '#type' => 'details',
      '#title' => t('Fields Settings'),
    ];
    $fields = $this->displayHandler->getFieldLabels(TRUE);
    foreach ($fields as $key => $field) {
      $form[$key] = [
        '#type' => 'details',
        '#title' => $key,
        '#fieldset' => 'fields_settings',
      ];
      $form[$key]['data-in'] = [
        '#type' => 'select',
        '#title' => t('data-in'),
        '#options' => [
          'left' => t('left'),
          'fade' => t('fade'),
          'none' => t('none'),
          'right' => t('right'),
          'top' => t('top'),
          'bottom' => t('bottom'),
          'bottomLeft' => t('bottomLeft'),
          'bottomRight' => t('bottomRight'),
          'topLeft' => t('topLeft'),
          'topRight' => t('topRight'),
        ],
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-in'] : '',
        '#description' => t('Type of the in-animation (default is left).'),
        '#fieldset' => $key,
      ];
      $form[$key]['data-out'] = [
        '#type' => 'select',
        '#title' => t('data-out'),
        '#options' => [
          'fade' => t('fade'),
          'none' => t('none'),
          'left' => t('left'),
          'right' => t('right'),
          'top' => t('top'),
          'bottom' => t('bottom'),
          'bottomLeft' => t('bottomLeft'),
          'bottomRight' => t('bottomRight'),
          'topLeft' => t('topLeft'),
          'topRight' => t('topRight'),
        ],
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-out'] : '',
        '#description' => t('Type of the out-animation (default is fade).'),
        '#fieldset' => $key,
      ];
      $form[$key]['data-step'] = [
        '#type' => 'select',
        '#title' => t('data-step'),
        '#options' => [
          0 => t('0'),
          1 => t('1'),
          2 => t('2'),
          3 => t('3'),
          4 => t('4'),
          5 => t('5'),
          6 => t('6'),
          7 => t('7'),
          8 => t('8'),
          9 => t('9'),
        ],
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-step'] : '',
        '#description' => t('You can group your elements in different steps. All animation of one step will start at the same time (maybe with your choosen element-specific data-delay). Elements of the next step will not start before the previous step is finished. If an element has no data-step attribute the plugin will thread it as having data-step=”0″.'),
        '#fieldset' => $key,
      ];
      $form[$key]['data-ease-in'] = [
        '#type' => 'select',
        '#title' => t('data-ease-in'),
        '#options' => [
          '' => t('-None-'),
          'linear' => t('linear'),
          'swing' => t('swing'),
          'easeInQuad' => t('easeInQuad'),
          'easeOutQuad' => t('easeOutQuad'),
          'easeInOutQuad' => t('easeInOutQuad'),
          'easeInCubic' => t('easeInCubic'),
          'easeOutCubic' => t('easeOutCubic'),
          'easeInOutCubic' => t('easeInOutCubic'),
          'easeInQuart' => t('easeInQuart'),
          'easeOutQuart' => t('easeOutQuart'),
          'easeInOutQuart' => t('easeInOutQuart'),
          'easeInQuint' => t('easeInQuint'),
          'easeOutQuint' => t('easeOutQuint'),
          'easeInOutQuint' => t('easeInOutQuint'),
          'easeInExpo' => t('easeInExpo'),
          'easeOutExpo' => t('easeOutExpo'),
          'easeInOutExpo' => t('easeInOutExpo'),
          'easeInSine' => t('easeInSine'),
          'easeOutSine' => t('easeOutSine'),
          'easeInOutSine' => t('easeInOutSine'),
          'easeInCirc' => t('easeInCirc'),
          'easeOutCirc' => t('easeOutCirc'),
          'easeInOutCirc' => t('easeInOutCirc'),
          'easeInElastic' => t('easeInElastic'),
          'easeOutElastic' => t('easeOutElastic'),
          'easeInOutElastic' => t('easeInOutElastic'),
          'easeInBack' => t('easeInBack'),
          'easeOutBack' => t('easeOutBack'),
          'easeInOutBack' => t('easeInOutBack'),
          'easeInBounce' => t('easeInBounce'),
          'easeOutBounce' => t('easeOutBounce'),
          'easeInOutBounce' => t('easeInOutBounce'),
        ],
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-ease-in'] : '',
        '#description' => t('easing for the animations (you can use all in jquery-ui contained <a target="_blank" href="http://jqueryui.com/effect/#easing">easing methods)</a>.'),
        '#fieldset' => $key,
      ];
      $form[$key]['data-ease-out'] = [
        '#type' => 'select',
        '#title' => t('data-ease-out'),
        '#options' => [
          '' => t('-None-'),
          'linear' => t('linear'),
          'swing' => t('swing'),
          'easeInQuad' => t('easeInQuad'),
          'easeOutQuad' => t('easeOutQuad'),
          'easeInOutQuad' => t('easeInOutQuad'),
          'easeInCubic' => t('easeInCubic'),
          'easeOutCubic' => t('easeOutCubic'),
          'easeInOutCubic' => t('easeInOutCubic'),
          'easeInQuart' => t('easeInQuart'),
          'easeOutQuart' => t('easeOutQuart'),
          'easeInOutQuart' => t('easeInOutQuart'),
          'easeInQuint' => t('easeInQuint'),
          'easeOutQuint' => t('easeOutQuint'),
          'easeInOutQuint' => t('easeInOutQuint'),
          'easeInExpo' => t('easeInExpo'),
          'easeOutExpo' => t('easeOutExpo'),
          'easeInOutExpo' => t('easeInOutExpo'),
          'easeInSine' => t('easeInSine'),
          'easeOutSine' => t('easeOutSine'),
          'easeInOutSine' => t('easeInOutSine'),
          'easeInCirc' => t('easeInCirc'),
          'easeOutCirc' => t('easeOutCirc'),
          'easeInOutCirc' => t('easeInOutCirc'),
          'easeInElastic' => t('easeInElastic'),
          'easeOutElastic' => t('easeOutElastic'),
          'easeInOutElastic' => t('easeInOutElastic'),
          'easeInBack' => t('easeInBack'),
          'easeOutBack' => t('easeOutBack'),
          'easeInOutBack' => t('easeInOutBack'),
          'easeInBounce' => t('easeInBounce'),
          'easeOutBounce' => t('easeOutBounce'),
          'easeInOutBounce' => t('easeInOutBounce'),
        ],
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-ease-out'] : '',
        '#description' => t('easing for the animations (you can use all in jquery-ui contained <a target="_blank" href="http://jqueryui.com/effect/#easing">easing methods)</a>.'),
        '#fieldset' => $key,
      ];
      $form[$key]['data-time'] = [
        '#title' => t('Data Time'),
        '#description' => t('Time after which the elements animation is complete. It will start at the beginning of the slide/step, or after its specificed delay. Default is 1000. Add 00 for none/instead of 0.'),
        '#type' => 'textfield',
        '#size' => '10',
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['data-time'] : '1000',
        '#fieldset' => $key,
      ];
      $form[$key]['space'] = [
        '#title' => t('Field Spacing Top'),
        '#description' => t('The Space/Gap between fields while sliding. Similar padding-top. Default is 30. Add 00 for none/instead of 0.'),
        '#type' => 'textfield',
        '#size' => '10',
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['space'] : '30',
        '#fieldset' => $key,
      ];
      $form[$key]['lspace'] = [
        '#title' => t('Field Spacing Left'),
        '#description' => t('The Space/Gap between fields while sliding. Similar padding-left. Default is 30. Add 00 for none/instead of 0.'),
        '#type' => 'textfield',
        '#size' => '10',
        '#default_value' => !empty($this->options[$key]) ? $this->options[$key]['lspace'] : '30',
        '#fieldset' => $key,
      ];

    }
  }

}
