<?php

namespace Reliv\Server;

/**
 * Class EnvFile
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class EnvFile
{
    /**
     * @var string
     */
    protected $env;

    /**
     * @var string
     */
    protected $path;

    /**
     * EnvFile constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = realpath($path);
    }

    /**
     * __invoke
     *
     * @return string
     */
    public function __invoke()
    {
        if (empty($this->env)) {
            $this->env = trim(fgets(fopen($this->path, 'r')));
        }

        return $this->env;
    }
}
