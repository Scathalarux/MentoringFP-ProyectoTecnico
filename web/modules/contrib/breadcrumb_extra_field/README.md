# Breadcrumb Extra Field

Breadcrumb Extra Field allows you to print breadcrumb between fields.

For a full description of the module, visit the
[project page](https://www.drupal.org/project/breadcrumb_extra_field).

Submit bug reports and feature suggestions, or track changes in the
[issue queue](https://www.drupal.org/project/issues/breadcrumb_extra_field).


## Table of contents

- Requirements
- Installation
- Configuration
- Usage
- Maintainers


## Requirements

- Drupal 10.2 or higher
- Drupal 11
- PHP 8.1 or higher
- No additional modules outside of Drupal core


## Installation

### Using Composer (recommended)

```bash
composer require drupal/breadcrumb_extra_field
```

Once installed, enable the module:
```bash
drush en breadcrumb_extra_field
```

Or enable it through the UI at `/admin/modules`.

For more information, see [Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).


## Configuration

### 1. Set Permissions

Navigate to **People > Permissions** (`/admin/people/permissions`) and grant the "Administer breadcrumb extra field" permission to appropriate roles.

### 2. Enable Breadcrumb for Entity Types

1. Go to **Configuration > System > Breadcrumb Extra Field** (`/admin/config/system/breadcrumb-extra-field`)
2. Select the entity types and bundles where you want to enable the breadcrumb field
3. Save the configuration

### 3. Configure Display Settings

1. Navigate to the entity's display settings:
   - For content types: **Structure > Content types > [Your content type] > Manage display**
   - For other entities: Find the appropriate "Manage display" page
2. Find the "Breadcrumb" field in the list of fields
3. Configure its position and visibility settings
4. Save the display configuration

### 4. Clear Cache

After configuration, clear all caches:
```bash
drush cr
```

Or via UI at **Configuration > Performance > Clear all caches**.


## Usage

Once configured, the breadcrumb will automatically appear in the configured positions on your entity pages. The breadcrumb will:

- Display the hierarchical navigation path to the current page.
- Use your site's default breadcrumb builder.
- Respect any custom breadcrumb alterations from other modules.
- Be themeable like any other field.


## Maintainers

Current maintainers:
- Alberto Ortega ([albeorte](https://www.drupal.org/u/albeorte))
- Alejandro Cabarcos ([alejandro-cabarcos](https://www.drupal.org/u/alejandro-cabarcos))
- CRZDEV ([crzdev](https://www.drupal.org/u/crzdev))
- Viktor Holovachek ([AstonVictor](https://www.drupal.org/u/astonvictor))

This project has been sponsored by:
- **[Drupal](https://www.drupal.org)** - The open source CMS powering millions of websites and applications.
