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
    protected static $localConfigPath = '';

    /**
     * @var bool
     */
    protected static $environmentSet = false;

    /**
     * @var array
     */
    protected static $environment
        = [
            'name' => 'prod',
            'isProduction' => true,
            'initSet' => [
            ],
        ];

    /**
     * setLocalConfigPath
     *
     * @param $localConfigPath
     *
     * @return void
     */
    public static function setLocalEnvironment($localConfigPath)
    {
        if (self::$environmentSet) {
            return;
        }
        self::$localConfigPath = $localConfigPath;
        self::setEnvironment();
    }

    /**
     * setEnvironment
     *
     * @return void
     */
    public static function setEnvironment()
    {
        if (self::$environmentSet) {
            return;
        }
        // Assume default if config file not found
        if (!file_exists(self::$localConfigPath)) {
            self::$environmentSet = true;
            trigger_error(
                'localConfigPath not set',
                E_USER_WARNING
            );

            return;
        }

        $config = include(self::$localConfigPath);

        // Assume default if config not found
        if (!$config['ServerEnvironment']) {
            self::$environmentSet = true;
            trigger_error(
                "Config value 'ServerEnvironment' not set",
                E_USER_WARNING
            );

            return;
        }

        self::$environment = array_merge(
            self::$environment,
            $config['ServerEnvironment']
        );

        foreach (self::$environment['initSet'] as $key => $value) {
            ini_set($key, $value);
        }
        self::$environmentSet = true;

    }

    /**
     * getEnvironment
     *
     * @return array
     */
    public static function getEnvironment()
    {
        return self::$environment;
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
        return ($name == self::$environment['name']);
    }

    /**
     * isProduction
     *
     * @return mixed
     */
    public static function isProduction()
    {
        return (self::$environment['isProduction']);
    }
}
