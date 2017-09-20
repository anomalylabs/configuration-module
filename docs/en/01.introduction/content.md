---
title: Introduction
---

## Introduction[](#introduction)

Powerful object instance configuration and management services.


### Features[](#introduction/features)

The Configuration module comes with everything you need to manage configuration values for addon instances.

*   Powered by Field Types
*   Compatible with any addon.
*   Easy integration with any project.


### Installation[](#introduction/installation)

You can install the Configuration module with the `addon:install` command:

    php artisan addon:install anomaly.module.configuration

<div class="alert alert-warning">**Notice:** The Configuration module comes installed with PyroCMS out of the box.</div>


### Configuration[](#introduction/configuration)

Configuration values are powered entirely by `field types`. This section will go over the basics of defining, managing, and using configuration for addons.


#### Configuration Keys[](#introduction/configuration/configuration-keys)

Configuration values are defined by a `key` and `scope`. The `key` is simply the `dot namespace` of the addon and the configuration field `slug`.

    anomaly.extension.xml_feed_widget::url

Because configuration can support multiple instances of the same addon you _must_ also provide a `scope`. The `scope` is any value your decide but is often an ID of an associated model entry.

Consider the above Dashboard module widget. The widget extension provides a configurable XML URL which you can define per instance. Each instance is tied to a widget `entry model` that's related to the given dashboard. In this scenario the `scope` is the ID of the dashboard widget entry model.


#### Defining Configuration[](#introduction/configuration/defining-configuration)

Configuration is defined using [field definitions](/documentation/streams-platform/v1.1#ui/forms/fields/the-field-definition) located in the addon's `resources/config/configuration.php` file:

    <?php

    return [
        'url' => [
            'type'   => 'anomaly.field_type.url',
            'config' => [
                'default_value' => 'http://www.pyrocms.com/posts/rss.xml',
            ],
        ],
    ];


#### Defining Form Sections[](#introduction/configuration/defining-form-sections)

You can also quickly define form sections the same as fields. To define sections move your `resources/config/configuration.php` file to `resources/configuration/configuration.php` and include a `resources/configuration/sections.php` file to define sections. The `sections.php` file simply returns an array of [section definitions](/documentation/streams-platform/v1.1#ui/control-panel/the-section-definition):

    <?php

    return [
        'general'      => [
            'context' => 'info',
            'title'   => 'example.module.test::label.general',
            'fields'  => [
                'name',
                'description',
            ],
        ],
    ];


#### Displaying Configuration Forms[](#introduction/configuration/displaying-configuration-forms)

Configuration can be set by `API` just like any other Stream entry however you may want to display a configuration form.

To get started you can extend or inject the `\Anomaly\ConfigurationModule\Configuration\Form\ConfigurationFormBuilder` class. The `entry` value for configuration form builders are the addon's `dot namespace`:

    use \Anomaly\ConfigurationModule\Configuration\Form\ConfigurationFormBuilder;

    public function edit(ConfigurationFormBuilder $builder, $id)
    {
        return $builder
            ->setScope($id)
            ->render('anomaly.extension.xml_feed_widget');
    }

<div class="alert alert-primary">**Pro Tip:** The configuration form builder is not much different than any other form builder so go crazy and extend or customize as needed in your own project.</div>
