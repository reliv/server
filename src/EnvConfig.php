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
     * @var string
     */
    protected $envFolderPrefix = '';

    /**
     * @param string $path
     * @param string $envFolderPrefix
     */
    public function __construct($path = 'config', $envFolderPrefix = '')
    {
        $this->path = $path;
        $this->envFolderPrefix = $envFolderPrefix;
    }

    /**
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
        $evn = Environment::get('name', 'production');
        $prefix = $this->envFolderPrefix;

        return "{$this->path}/{$prefix}{$evn}/*.php";
    }

    /**
     * @return \Generator
     */
    public function __invoke()
    {
        $pattern = $this->getPattern();

        foreach ($this->glob($pattern) as $file) {
            yield include $file;
        }
    }
}
