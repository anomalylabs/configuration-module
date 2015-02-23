<?php namespace Anomaly\ConfigurationsModule\Configuration;

use Anomaly\ConfigurationsModule\Configuration\Contract\ConfigurationInterface;
use Anomaly\ConfigurationsModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier;
use Illuminate\Config\Repository;

/**
 * Class ConfigurationRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\ConfigurationsModule\ConfigurationInterface
 */
class ConfigurationRepository implements ConfigurationRepositoryInterface
{

    /**
     * The configuration model.
     *
     * @var ConfigurationModel
     */
    protected $model;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new ConfigurationRepositoryInterface instance.
     *
     * @param ConfigurationModel $model
     * @param Repository   $config
     */
    public function __construct(ConfigurationModel $model, Repository $config)
    {
        $this->model  = $model;
        $this->config = $config;
    }

    /**
     * Find a configuration by it's key
     * or return a new instance.
     *
     * @param $key
     * @return ConfigurationInterface
     */
    public function findOrNew($key)
    {
        $configuration = $this->model->where('key', $key)->first();

        if (!$configuration) {
            return $this->model->newInstance();
        }

        return $configuration;
    }

    /**
     * Get a configuration value.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $configuration = $this->model->where('key', $key)->first();

        if (!$configuration) {
            return $this->config->get($key, $default);
        }

        $field = str_replace('::', '::configurations.', $key);

        $type = app(config($field . '.type', config($field)));

        $modifier = $type->getModifier();

        if ($modifier instanceof FieldTypeModifier) {
            return $modifier->restore($configuration->value);
        }

        return $configuration->value;
    }

    /**
     * Set a configuration value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $configuration = $this->model->where('key', $key)->first();

        if (!$configuration) {

            $configuration = $this->model->newInstance();

            $configuration->key = $key;
        }

        $field = str_replace('::', '::configurations.', $key);

        $type = app(config($field . '.type', config($field)));

        $modifier = $type->getModifier();

        if ($modifier instanceof FieldTypeModifier) {
            $value = $modifier->modify($value);
        }

        $configuration->value = $value;

        $configuration->save();

        return $this;
    }

    /**
     * Get all configurations for a namespace.
     *
     * @param $getNamespace
     * @return ConfigurationCollection
     */
    public function getAll($namespace)
    {
        $configurations = $this->model->where('key', 'LIKE', $namespace . '::%')->get();

        return new ConfigurationCollection($configurations->lists('value', 'key'));
    }
}