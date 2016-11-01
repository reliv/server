<?php

namespace Reliv\Server;

/**
 * Class EnvConfig
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class EnvConfig
{
    /**
     * @var string
     */
    protected $path;

    /**
     * EnvConfig constructor.
     *
     * @param string $path
     */
    public function __construct($path = 'config')
    {
        $this->path = $path;
    }

    /**
     * glob
     *
     * @param $pattern
     *
     * @return array
     */
    protected function glob($pattern)
    {
        return glob($pattern, GLOB_BRACE);
    }

    /**
     * getPattern
     *
     * @return string
     */
    protected function getPattern()
    {
        $evn = \Reliv\Server\Environment::get('name', 'production');

        return "{$this->path}/{$evn}/*.php";
    }

    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        $pattern = $this->getPattern();

        foreach ($this->glob($pattern) as $file) {
            yield include $file;
        }
    }
}
