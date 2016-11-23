<?php

namespace Reliv\Server\Factory;

use Interop\Container\ContainerInterface;

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
     * __invoke
     *
     * @param ContainerInterface $container
     *
     * @return null|\Reliv\Server\Entity\Environment
     * @throws \Exception
     */
    public function __invoke(ContainerInterface $container)
    {
        $instance = \Reliv\Server\Environment::getInstance();

        if (empty($instance)) {
            throw new \Exception('Reliv\Server\Environment MUST be build before configuration.  No instance returned');
        }

        return $instance;
    }
}
