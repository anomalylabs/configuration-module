<?php namespace Anomaly\ConfigurationModule\Configuration\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationInterface;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class ModifyValue
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ModifyValue
{

    /**
     * The configuration value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * The configuration instance.
     *
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * Create a new ModifyValue instance.
     *
     * @param ConfigurationInterface $configuration
     * @param                        $value
     */
    public function __construct(ConfigurationInterface $configuration, $value)
    {
        $this->value         = $value;
        $this->configuration = $configuration;
    }

    /**
     * Handle the command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* @var FieldType $type */
        if ($type = dispatch_now(new GetValueFieldType($this->configuration))) {
            return $type->getModifier()->modify($this->value);
        }

        return $this->value;
    }
}
