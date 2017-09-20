---
title: Usage
---

## Usage[](#usage)

This section will show you how to use the addon via API and in the view layer.


### Configuration[](#usage/configuration)

This section will go over how to utilize the configuration values you have defined.


#### Configuration Interface[](#usage/configuration/configuration-interface)

This section will go over the `\Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationInterface` class.


##### ConfigurationInterface::field()[](#usage/configuration/configuration-interface/configurationinterface-field)

The `field` method returns the field type instance for the value or `null` if the configuration field no longer exists.

###### Returns: `\Anomaly\Streams\Platform\Addon\FieldType\FieldType` or `null`

###### Example

    $config = $configuration->get('anomaly.extension.xml_feed_widget::url');

    if ($field = $config->field()) {
        echo $field->getValue();
    }


#### Configuration Repository[](#usage/configuration/configuration-repository)

This section will go over the `\Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface` class.


##### ConfigurationRepositoryInterface::get()[](#usage/configuration/configuration-repository/configurationrepositoryinterface-get)

The `get` method returns the configuration instance.

###### Returns: `\Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationInterface`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$key

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration key.

</td>

</tr>

<tr>

<td>

$scope

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The configuration scope.

</td>

</tr>

</tbody>

</table>

###### Example

    $url = $configuration->value(
        'anomaly.extension.xml_feed_widget::url',
        $widget->getId()
    );

    echo $url->getValue();


##### ConfigurationRepositoryInterface::set()[](#usage/configuration/configuration-repository/configurationrepositoryinterface-set)

The `set` method allows you to set a configuration value.

<div class="alert alert-info">**Note:** Values are passed through the configuration field's **modifier**.</div>

###### Returns: `boolean`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$key

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration key.

</td>

</tr>

<tr>

<td>

$scope

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration scope.

</td>

</tr>

<tr>

<td>

$value

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The configuration value.

</td>

</tr>

</tbody>

</table>

###### Example

    $configuration->set(
        'anomaly.extension.xml_feed_widget::url',
        $this->widget->getId(),
        'http://www.pyrocms.com/posts/rss.xml'
    );


##### ConfigurationRepositoryInterface::value()[](#usage/configuration/configuration-repository/configurationrepositoryinterface-value)

The `value` method returns the value as the configuration field type normally would with `getType`.

###### Returns: `mixed`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$key

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration key.

</td>

</tr>

<tr>

<td>

$key

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration key.

</td>

</tr>

<tr>

<td>

$default

</td>

<td>

false

</td>

<td>

mixed

</td>

<td>

null

</td>

<td>

The default value.

</td>

</tr>

</tbody>

</table>

###### Example

    $value = $configuration->value(
        'anomaly.extension.xml_feed_widget::url',
        $this->widget->getId(),
        'http://www.pyrocms.com/posts/rss.xml'
    )


##### ConfigurationRepositoryInterface::presenter()[](#usage/configuration/configuration-repository/configurationrepositoryinterface-presenter)

The `presenter` method returns the configuration value's field type presenter or `null` if the configuration no longer exists.

###### Returns: `\Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter` or `null`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$key

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The configuration key.

</td>

</tr>

<tr>

<td>

$scope

</td>

<td>

true

</td>

<td>

mixed

</td>

<td>

none

</td>

<td>

The configuration scope.

</td>

</tr>

</tbody>

</table>

###### Example

    $url = $configuration->value(
        'anomaly.extension.xml_feed_widget::url',
        $this->widget->getId()
    );

    echo $url->link('Example Link!');
