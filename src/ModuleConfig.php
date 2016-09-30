<?php

namespace Reliv\Server;

/**
 * Class ModuleConfig for Expressive
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return require(__DIR__ . '/../config/config.php');
    }
}
