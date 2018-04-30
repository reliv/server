<?php

namespace Reliv\Server;

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
    protected static $configKey = 'RelivServerEnvironment';

    /**
     * @var string
     */
    protected static $localConfigPath = '';

    /**
     * @var null|\Reliv\Server\Entity\Environment
     */
    protected static $instance = null;

    /**
     * getEnvName
     *
     * @param callable|null $envGetter
     *
     * @return mixed
     */
    protected static function getEnvName(callable $envGetter = null)
    {
        if (!$envGetter) {
            $envGetter = new EnvVar();
        }

        return $envGetter();
    }

    /**
     * getInstance
     *
     * @return null|\Reliv\Server\Entity\Environment
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * buildInstanceEnv
     *
     * @param string $localConfigPath
     * @param callable|null $envGetter
     * @param null $configKey
     *
     * @return null|Entity\Environment
     */
    public static function buildInstanceEnv(
        $localConfigPath,
        callable $envGetter = null,
        $configKey = null
    ) {
        if (self::$instance) {
            return self::$instance;
        }

        $envName = self::getEnvName($envGetter);

        return self::buildInstance(
            $localConfigPath,
            $configKey,
            $envName
        );
    }

    /**
     * buildInstance
     *
     * @param string $localConfigPath
     * @param string $envName
     * @param string $configKey
     *
     * @return null|Entity\Environment
     * @throws \Exception
     */
    public static function buildInstance(
        $localConfigPath,
        $envName = null,
        $configKey = null
    ) {
        if (self::$instance) {
            return self::$instance;
        }

        if ($envName === null) {
            $envName = self::getEnvName(null);
        }

        if (empty($envName)) {
            throw new \Exception('envName is empty');
        }

        if (!empty($configKey)) {
            self::$configKey = $configKey;
        }
        $configKey = self::$configKey;

        $configPath = $localConfigPath . '/' . $envName . '.php';

        // Assume default if config file not found
        if (!file_exists($configPath)) {
            trigger_error(
                'localConfigPath not set',
                E_USER_WARNING
            );

            self::$instance = self::build(
                $envName,
                [],
                $configPath
            );

            return self::$instance;
        }

        $config = include($configPath);

        $overrideConfigPath = $localConfigPath . '/' . $envName . '-override.php';
        if (file_exists($overrideConfigPath)) {
            $config = array_replace_recursive($config, include($overrideConfigPath));
            var_dump($config);
        }

        // Assume default if config not found
        if (!$config[$configKey]) {
            trigger_error(
                "Config value {$configKey} not set",
                E_USER_WARNING
            );

            self::$instance = self::build(
                $envName,
                [],
                $configPath
            );

            return self::$instance;
        }

        self::$instance = self::build(
            $envName,
            $config[$configKey],
            $configPath
        );

        return self::$instance;
    }

    /**
     * build
     *
     * @param string $envName
     * @param array $config
     * @param string $configPath
     *
     * @return Entity\Environment
     */
    protected static function build(
        $envName,
        array $config,
        $configPath = null
    ) {
        $instance = new \Reliv\Server\Entity\Environment(
            $envName,
            $config,
            $configPath
        );

        $initSet = $instance->get('initSet', []);

        foreach ($initSet as $key => $value) {
            ini_set($key, $value);
        }

        return $instance;
    }

    /**
     * @deprecated Use self::buildInstance()
     * setLocalEnvironment
     *
     * @param string $localConfigPath
     * @param null $envName
     * @param null $configKey
     *
     * @return \Reliv\Server\Entity\Environment
     * @throws \Exception
     */
    public static function setLocalEnvironment(
        $localConfigPath,
        $envName = null,
        $configKey = null
    ) {
        return self::buildInstance(
            $localConfigPath,
            $envName,
            $configKey
        );
    }

    /**
     * isEnvironment
     *
     * @param $name
     *
     * @return bool
     */
    public static function isEnvironment($name)
    {
        // @BC Return a default if instance not set
        if (empty(self::$instance)) {
            return false;
        }

        return self::$instance->isEnvironment($name);
    }

    /**
     * isProduction
     *
     * @return bool
     */
    public static function isProduction()
    {
        // @BC Return a default if instance not set
        if (empty(self::$instance)) {
            return true;
        }

        return self::$instance->isProduction();
    }

    /**
     * getName
     *
     * @return string
     */
    public static function getName()
    {
        // @BC Return a default if instance not set
        if (empty(self::$instance)) {
            return 'UNDEFINED';
        }

        return self::$instance->getName();
    }

    /**
     * get
     *
     * @param string $key
     * @param null|mixed $default
     *
     * @return mixed|null
     */
    public static function get($key, $default = null)
    {
        // @BC
        if ($key === 'name') {
            return self::getName();
        }

        // @BC Return a default if instance not set
        if (empty(self::$instance)) {
            return $default;
        }

        return self::$instance->get($key, $default);
    }
}
