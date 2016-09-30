<?php

namespace Reliv\Server\Entity;

/**
 * Class Environment
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class Environment
{
    /**
     * @var string
     */
    protected $configPath;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options
        = [
            'isProduction' => true,
            'initSet' => [
            ],
        ];

    /**
     * Environment constructor.
     *
     * @param string $envName
     * @param array  $options
     * @param string $configPath
     */
    public function __construct(
        $envName,
        array $options = [],
        $configPath = null
    ) {
        $this->setName($envName);
        $this->setOptions($options);
        $this->configPath = $configPath;
    }

    /**
     * setOptions
     *
     * @param $options
     *
     * @return void
     */
    protected function setOptions($options)
    {
        if (empty($options)) {
            return;
        }

        $this->options = array_merge(
            $this->options,
            $options
        );
    }

    /**
     * getOptions
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * setName
     *
     * @param string $envName
     *
     * @return void
     */
    protected function setName($envName)
    {
        $this->name = (string)$envName;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getConfigPath
     *
     * @return string
     */
    public function getConfigPath()
    {
        return $this->configPath;
    }

    /**
     * get
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }

        return $default;
    }

    /**
     * isEnvironment
     *
     * @param $name
     *
     * @return bool
     */
    public function isEnvironment($name)
    {
        $serverName = $this->getName();

        return ($name === $serverName);
    }

    /**
     * isProduction
     *
     * @return bool
     */
    public function isProduction()
    {
        $isProduction = (bool)$this->get('isProduction', true);

        return $isProduction;
    }
}
