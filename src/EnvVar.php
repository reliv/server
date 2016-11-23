<?php

namespace Reliv\Server;

/**
 * Class EnvVar
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class EnvVar
{
    /**
     * @var string
     */
    protected $env;

    /**
     * @var string
     */
    protected $varName;

    /**
     * EnvVar constructor.
     *
     * @param string $varName
     */
    public function __construct($varName = 'ENV')
    {
        $this->varName = $varName;
    }

    /**
     * __invoke
     *
     * @return string
     */
    public function __invoke()
    {
        if (empty($this->env)) {
            $this->env = getenv($this->varName);
        }

        return $this->env;
    }
}
