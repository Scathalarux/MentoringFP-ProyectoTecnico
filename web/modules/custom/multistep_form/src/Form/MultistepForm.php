<?php

namespace Drupal\multistep_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MultistepForm extends FormBase {

  protected $step = 1;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multistep_form';
  }

    /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->step = $form_state->get('step') ?? 1;

    // Barra de progresión
    $form['progress'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['progress-bar']],
      'bar' => [
        '#markup' => $this->generateProgressBar($this->step),
      ],
    ];

    switch ($this->step) {
      case 1:
        $form = $this->stepOne($form, $form_state);
        break;

      case 2:
        $form = $this->stepTwo($form, $form_state);
        break;

      case 3:
        $form = $this->stepThree($form, $form_state);
        break;
    }

    $form['#attached']['library'][] = 'multistep_form/multistepcss';
    return $form;
  }

    /**
    * Step 1: nombre y apellidos
    */
    public function stepOne(array &$form, FormStateInterface $form_state){
        $stored_values = $form_state->get('step_data_1') ?? [];

        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Nombre'),
            '#default_value' => $stored_values['name'] ?? '',
            '#required' => TRUE,
        ];
        $form['surname'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Apellidos'),
            '#default_value' => $stored_values['surname'] ?? '',
            '#required' => TRUE,
        ];

        $this->addNavigationButtons($form, 1);
        return $form;

    }

    /**
    * Step 2: datos de contacto
    */
    public function stepTwo(array &$form, FormStateInterface $form_state){
        $stored_values = $form_state->get('step_data_2') ?? [];

        $form['phone'] = [
            '#type' => 'tel',
            '#title' => $this->t('Teléfono'),
            '#default_value' => $stored_values['phone'] ?? '',
            '#required' => TRUE,
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#default_value' => $stored_values['email'] ?? '',
            '#required' => TRUE,
        ];

        $this->addNavigationButtons($form, 2);
        return $form;

    }

    /**
    * Step 3: comentarios
    */
    public function stepThree(array &$form, FormStateInterface $form_state){
        $stored_values = $form_state->get('step_data_3') ?? [];

        $form['observations'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Comentarios y observaciones'),
            '#default_value' => $stored_values['observations'] ?? '',
            '#required' => FALSE,
        ];
    
        $this->addNavigationButtons($form, 3);
        return $form;

    }

    /**
    * Función para la validación 
    */
    public function checkForm(array &$form, FormStateInterface $form_state){
    $triggering_element = $form_state->getTriggeringElement();

        if($triggering_element['#value'] === $this->t('Volver')){
            return;
        }

        if($this->step === 1){
            if(!preg_match('/[\p{L}]{3,}/',$form_state_interface->getValue('name'))){
                $form_state->setErrorByName('name', $this->t('Introduzca un nombre con más de 3 caracteres'));
            }
        
            if(!preg_match('/[\p{L}]{3,}/',$form_state_interface->getValue('surname'))){
                $form_state->setErrorByName('surname', $this->t('Introduzca apellidos con más de 3 caracteres'));
            } 
        }

        if($this->step === 2){
            if(!filter_var($form_state_interface->getValue('email'), FILTER_VALIDATE_EMAIL)){
                $form_state->setErrorByName('email', $this->t('Introduzca un email válido'));
            }

            if(!preg_match('/[0-9]{9,13}/',$form_state_interface->getValue('phone'))){
                $form_state->setErrorByName('phone', $this->t('Introduzca un teléfono válido'));
            } 
        }

    }


    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state){   
        $form_state->set('step_data_'.$this->step, $form_state->getValues());

        if($this->step <3){

            $form_state->set('step', $this->step + 1);
            $form_state->setRebuild(TRUE);

        }else{
            
            \Drupal::messenger()->addMessage($this->t('Datos enviados con éxito'));
            $form_state->set('step', 1);
            $form_state->set('step_data_1', NULL);
            $form_state->set('step_data_2', NULL);
            $form_state->set('step_data_3', NULL);
            $form_state->setRebuild(TRUE);
            
        }
    }

/**
   * Adds navigation buttons.
   */
  private function addNavigationButtons(array &$form, $step) {
    if ($step > 1) {
      $form['back'] = [
        '#type' => 'submit',
        '#value' => $this->t('Back'),
        '#submit' => ['::backStep'],
        '#limit_validation_errors' => [], 
      ];
    }
    $form['next'] = [
      '#type' => 'submit',
      '#value' => $step < 3 ? $this->t('Next') : $this->t('Submit'),
    ];
  }

  /**
   * Back button submit handler.
   */
  public function backStep(array &$form, FormStateInterface $form_state) {
    $form_state->set('step', $this->step - 1);
    $form_state->setRebuild(TRUE);
  }

  /**
   * Generate progress bar.
   */
  private function generateProgressBar($current_step) {
    $steps = [
      1 => $this->t('Nombre y apellidos'),
      2 => $this->t('Datos de contacto'),
      3 => $this->t('Comentarios'),
    ];
  
    $markup = '<div class="progress-container">';
    foreach ($steps as $step => $label) {
      $active_class = ($step === $current_step) ? 'active' : (($step < $current_step) ? 'completed' : '');
      $markup .= '<div class="progress-step ' . $active_class . '">';
      $markup .= '<div class="progress-circle">' . $step . '</div>';
      $markup .= '<div class="progress-label">' . $label . '</div>';
      $markup .= '</div>';
    }
    $markup .= '</div>';
  
    return $markup;
  }
}

