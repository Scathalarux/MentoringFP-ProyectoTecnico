<?php

namespace Drupal\breadcrumb_extra_field\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * BreadcrumbExtraFieldSettingsForm Class adds a config form for the module.
 */
class BreadcrumbExtraFieldSettingsForm extends ConfigFormBase {

  /**
   * Returns the entity_type.manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Returns the entity_type.bundle.info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;

  /**
   * Constructs a BreadcrumbExtraFieldSettingsForm form.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Config\TypedConfigManagerInterface $typed_config_manager
   *   The typed config manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Provides an interface for entity type managers.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   Provides an interface for an entity type bundle info.
   */
  public function __construct(ConfigFactoryInterface $config_factory, TypedConfigManagerInterface $typed_config_manager, EntityTypeManagerInterface $entity_type_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info) {
    parent::__construct($config_factory, $typed_config_manager);

    $this->entityTypeManager = $entity_type_manager;
    $this->entityTypeBundleInfo = $entity_type_bundle_info;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('config.typed'),
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'breadcrumb_extra_field_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['breadcrumb_extra_field.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('breadcrumb_extra_field.settings');

    $entity_info = $this->entityTypeManager->getDefinitions();
    $admin = $config->get('breadcrumb_extra_field_admin');

    $form['breadcrumb_extra_field_admin'] = [
      '#type' => 'details',
      '#title' => $this->t('Select entity types which are going to use the breadcrumb extra field'),
      '#open' => TRUE,
      '#tree' => TRUE,
      '#description' => $this->t('Enable extra field for these entity types and bundles.'),
    ];

    // Skip not allowed entity types.
    foreach ($entity_info as $entity_type_key => $entity_type) {
      $interfaces = class_implements($entity_type->getOriginalClass());
      if ($interfaces && in_array(FieldableEntityInterface::class, $interfaces) && $entity_type->getLinkTemplate('canonical')) {
        $bundles = $this->entityTypeBundleInfo->getBundleInfo($entity_type_key);

        $bundle_options = [];
        foreach ($bundles as $bundle_key => $bundle) {
          $bundle_options[$bundle_key] = $bundle['label'];
        }

        $form['breadcrumb_extra_field_admin'][$entity_type_key] = [
          '#type' => 'checkboxes',
          '#title' => $entity_type->getLabel(),
          '#options' => $bundle_options,
          '#default_value' => !empty($admin[$entity_type_key]) ?
          array_keys(array_filter($admin[$entity_type_key])) : [],
        ];
      }
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity_types = [];
    foreach ($form_state->getValue('breadcrumb_extra_field_admin') as $entity_type => $bundles) {
      if ($bundles) {
        $entity_types[$entity_type] = $bundles;
      }
    }

    $this->config('breadcrumb_extra_field.settings')
      ->set('breadcrumb_extra_field_admin', $entity_types)
      ->save();

    Cache::invalidateTags(['entity_field_info']);
    parent::submitForm($form, $form_state);
  }

}
