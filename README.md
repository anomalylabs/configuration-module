# Configuration Module

*anomaly.module.configuration*

#### Addon configuration management for the Streams Platform.

The Configuration Module provides a powerful interface for managing addon configurations with database-backed storage and field-based editing.

## Features

- Database-backed configuration storage
- Field-based configuration editing
- Per-addon configuration management
- Configuration scoping (global, per-user, per-site)
- Default value handling
- Configuration caching
- Validation support
- Import/export functionality
- Version control friendly

## Installation

The Configuration Module is included by default in PyroCMS installations.

## Configuration Structure

### Defining Configuration Fields

Addons can define configuration fields in their `config/config.php` file:

```php
return [
    'per_page' => [
        'type'   => 'anomaly.field_type.integer',
        'config' => [
            'default_value' => 25,
            'min'            => 1,
            'max'            => 100
        ]
    ],
    'enabled' => [
        'type'   => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => true
        ]
    ],
    'api_key' => [
        'type'   => 'anomaly.field_type.encrypted',
        'config' => [
            'placeholder' => 'Enter your API key'
        ]
    ]
];
```

## Usage

### Accessing Configuration Values

#### In PHP

```php
// Get configuration value
$perPage = config('anomaly.module.posts::per_page');

// Get with default
$apiKey = config('anomaly.module.posts::api_key', 'default-key');

// Using the config helper
$enabled = config('streams::posts.enabled');
```

#### In Twig Templates

```twig
{# Get configuration value #}
{{ config('anomaly.module.posts::per_page') }}

{# Check boolean configuration #}
{% if config('anomaly.module.posts::enabled') %}
    <p>Feature is enabled</p>
{% endif %}
```

### Setting Configuration Values

#### Programmatically

```php
use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;

$config = app(ConfigurationRepositoryInterface::class);

// Set configuration value
$config->set('anomaly.module.posts::per_page', 50);

// Set multiple values
$config->set([
    'anomaly.module.posts::per_page' => 50,
    'anomaly.module.posts::enabled'  => true
]);
```

#### Via Control Panel

Navigate to: **Settings > Configuration** and select the addon to configure.

## Configuration Scopes

### Global Scope

Default scope that applies to all users and sites:

```php
$config->set('anomaly.module.posts::per_page', 25);
```

### User Scope

Configuration specific to a user:

```php
$config->scope('user', $userId)->set('anomaly.module.posts::theme', 'dark');
```

### Site Scope

Configuration specific to a site (multisite):

```php
$config->scope('site', $siteId)->set('anomaly.module.posts::enabled', true);
```

## Advanced Features

### Configuration Caching

Configuration values are automatically cached for performance:

```php
// Clear configuration cache
php artisan cache:clear

// Or clear specific addon config
$config->forgetCache('anomaly.module.posts');
```

### Import/Export

Export configuration for version control:

```php
// Export addon configuration
php artisan configuration:export anomaly.module.posts

// Import configuration
php artisan configuration:import anomaly.module.posts
```

### Default Values

Set default values when configuration is not found:

```php
return [
    'items_per_page' => [
        'type'   => 'anomaly.field_type.integer',
        'config' => [
            'default_value' => 15
        ]
    ]
];
```

## Field Types

All Streams Platform field types are supported:

### Common Configuration Fields

#### Text Input
```php
'site_name' => [
    'type' => 'anomaly.field_type.text'
]
```

#### Integer
```php
'max_items' => [
    'type'   => 'anomaly.field_type.integer',
    'config' => [
        'min' => 1,
        'max' => 1000
    ]
]
```

#### Boolean
```php
'enabled' => [
    'type'   => 'anomaly.field_type.boolean',
    'config' => [
        'default_value' => true
    ]
]
```

#### Select Dropdown
```php
'theme' => [
    'type'   => 'anomaly.field_type.select',
    'config' => [
        'options' => [
            'light' => 'Light',
            'dark'  => 'Dark'
        ]
    ]
]
```

#### Encrypted
```php
'api_secret' => [
    'type' => 'anomaly.field_type.encrypted'
]
```

## Database Structure

Configuration values are stored in:
- **configurations_configurations** - Main configuration table
- Stores: addon, key, value, scope, scope_id

## Best Practices

1. **Use Sensible Defaults**: Always provide default values in field definitions
2. **Validate Input**: Use field type validation rules
3. **Cache Wisely**: Configuration is cached automatically, clear cache after updates
4. **Document Configuration**: Add comments to configuration field definitions
5. **Scope Appropriately**: Use scopes when configuration differs per user/site
6. **Secure Sensitive Data**: Use encrypted field type for API keys and secrets
7. **Version Control**: Keep configuration definitions in version control

## API

### ConfigurationRepositoryInterface

```php
// Get configuration value
$value = $config->get($key, $default = null);

// Set configuration value
$config->set($key, $value);

// Check if configuration exists
$exists = $config->has($key);

// Delete configuration
$config->forget($key);

// Get all configurations for addon
$all = $config->all($addon);

// Set scope
$config->scope($scope, $scopeId);
```

## Events

- `Anomaly\ConfigurationModule\Configuration\Event\ConfigurationWasSaved`
- `Anomaly\ConfigurationModule\Configuration\Event\ConfigurationWasDeleted`

## Requirements

- Streams Platform ^1.10
- PyroCMS 3.10+

## License

The Configuration Module is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Authors

PyroCMS, Inc. - [https://pyrocms.com](https://pyrocms.com)
Ryan Thompson - [ryan@pyrocms.com](mailto:ryan@pyrocms.com)
