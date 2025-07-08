<?php

namespace Drupal\Tests\breadcrumb_extra_field\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\node\Entity\NodeType;

/**
 * Tests for breadcrumb extra field.
 *
 * @group breadcrumb_extra_field
 */
class BreadcrumbExtraFieldTest extends BrowserTestBase {

  /**
   * Default theme.
   *
   * @var string
   */
  protected $defaultTheme = 'stark';

  /**
   * Modules to enable.
   *
   * @var array<string>
   */
  protected static $modules = [
    'field',
    'field_ui',
    'node',
    'breadcrumb_extra_field',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    // Create article content type.
    NodeType::create([
      'type' => 'article',
      'name' => 'Article',
    ])->save();

    // Rebuild router after creating content type.
    $this->container->get('router.builder')->rebuild();
  }

  /**
   * Tests access control for the admin UI.
   */
  public function testAdminAccessControl(): void {
    // Check access denied for user without permission.
    $account = $this->drupalCreateUser();
    $this->drupalLogin($account);
    $this->drupalGet('admin/config/system/breadcrumb-extra-field');
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests that the admin UI configuration options work.
   */
  public function testAdminUi(): void {
    // Check access for user with permission.
    $admin_account = $this->drupalCreateUser([
      'administer breadcrumb extra field',
      'administer node display',
      'administer node fields',
    ]);
    $this->drupalLogin($admin_account);

    // Check extra field visibility before configuration.
    $this->drupalGet('admin/structure/types/manage/article/display');
    $this->assertSession()->elementNotExists('xpath', '//tr[@data-drupal-selector="edit-fields-breadcrumb"]');

    // Check allowed access to settings page.
    $this->drupalGet('admin/config/system/breadcrumb-extra-field');
    $this->assertSession()->statusCodeEquals(200);

    // Check that article bundle checkbox exists.
    $this->assertSession()->fieldExists('breadcrumb_extra_field_admin[node][article]');

    // Enable breadcrumb for articles.
    $edit = ['breadcrumb_extra_field_admin[node][article]' => TRUE];
    $this->submitForm($edit, 'Save configuration');
    $this->assertSession()->pageTextContains('The configuration options have been saved.');

    // Clear cache after configuration.
    $this->resetAll();

    // Check extra field visibility after configuration.
    $this->drupalGet('admin/structure/types/manage/article/display');
    $this->assertSession()->elementExists('xpath', '//tr[@data-drupal-selector="edit-fields-breadcrumb"]');
    // Check label exists.
    $this->assertSession()->pageTextContains('Breadcrumb');
  }

  /**
   * Tests breadcrumb display visibility when not configured.
   */
  public function testDisplayVisibility(): void {
    // Create a test node.
    $node = $this->drupalCreateNode([
      'type' => 'article',
      'title' => 'Test Article',
    ]);

    $this->drupalGet('node/' . $node->id());

    // Check breadcrumb is not visible before configuration.
    $this->assertSession()->elementNotExists('css', 'nav[role="navigation"][aria-labelledby="system-breadcrumb"]');
  }

  /**
   * Tests breadcrumb field configuration and display settings.
   */
  public function testBreadcrumbFieldConfiguration(): void {
    // Create a test node.
    $node = $this->drupalCreateNode([
      'type' => 'article',
      'title' => 'Test Article',
    ]);

    // Configure module to enable breadcrumb for articles.
    $admin_account = $this->drupalCreateUser(['administer breadcrumb extra field']);
    $this->drupalLogin($admin_account);

    // Enable breadcrumb for articles.
    $this->drupalGet('admin/config/system/breadcrumb-extra-field');
    $edit = ['breadcrumb_extra_field_admin[node][article]' => TRUE];
    $this->submitForm($edit, 'Save configuration');

    // Clear cache after configuration.
    $this->resetAll();

    // Create new session to test the actual display.
    $this->initMink();

    // Check breadcrumb is still not visible (not enabled in display yet).
    $this->drupalGet('node/' . $node->id());
    $this->assertSession()->elementNotExists('css', 'nav[role="navigation"][aria-labelledby="system-breadcrumb"]');

    // Enable breadcrumb in display settings.
    /** @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface $display_repository */
    $display_repository = \Drupal::service('entity_display.repository');
    $display = $display_repository->getViewDisplay('node', 'article', 'default');
    $display->setComponent('breadcrumb', [
      'region' => 'content',
      'weight' => -10,
    ]);
    $display->save();

    // Check breadcrumb is now visible.
    $this->drupalGet('node/' . $node->id());
    $this->assertSession()->elementExists('css', 'nav[role="navigation"][aria-labelledby="system-breadcrumb"]');
  }

}
