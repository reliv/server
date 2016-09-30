<?php

namespace Reliv\Server\Middleware;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

/**
 * Class Environment
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class Environment implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $localConfigPath;

    /**
     * @var null|string
     */
    protected $envName = null;

    /**
     * @var null|string
     */
    protected $configKey = null;

    /**
     * Environment constructor.
     *
     * @param string             $localConfigPath
     * @param string|null        $envName
     * @param string|null        $configKey
     */
    public function __construct(
        $localConfigPath,
        $envName = null,
        $configKey = null
    ) {
        $this->localConfigPath = $localConfigPath;
        $this->envName = $envName;
        $this->configKey = $configKey;
    }

    /**
     * __invoke
     *
     * @param Request           $request
     * @param Response          $response
     * @param callable|Response $out
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $instance = \Reliv\Server\Environment::buildInstance(
            $this->localConfigPath,
            $this->envName,
            $this->configKey
        );

        return $out($request, $response);
    }
}
