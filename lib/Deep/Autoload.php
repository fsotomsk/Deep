<?php

/**
 * Project: cDeep
 * File: Autoload.php
 * User: fso
 * Date: 07.11.2014
 * Time: 20:20
 * Description:
 */

namespace Deep;

/**
 * Class Autoload
 * @package Deep
 */
class Autoload
{

    /**
     * @var array
     */
    private $includePaths = [];
    /**
     * @var array
     */
    private $loadedFiles = [];
    /**
     * @var mixed
     */
    private $postLoadHandlers = [];

    /**
     * Autoload constructor.
     * @param array $paths
     */
    public function __construct($paths = [])
    {
        if ($paths) {
            $this->includePaths = array_unique($paths);
        }
        spl_autoload_register([$this, 'resolveClass'], true, true);
    }

    /**
     * @param callable $callback
     */
    public function addPostLoadHandler(callable $callback)
    {
        $this->postLoadHandlers[] = $callback;
    }

    /**
     * @param string $path
     * @return array
     */
    public function addClassPath($path)
    {
        if (!in_array($path, $this->includePaths)) {
            $this->includePaths[] = $path;
        }
        return $this->includePaths;
    }

    /**
     * @param string $className
     * @return boolean|null
     */
    public function resolveClass($className)
    {
        $classFileName = str_replace(['_', '\\'], '/', $className) . '.php';
        foreach ($this->includePaths as $path) {
            $fileName = $path . $classFileName;
            if (file_exists($fileName)) {
                require_once($fileName);
                $this->loadedFiles[$className] = $fileName;
                if ($this->postLoadHandlers) {
                    foreach ($this->postLoadHandlers as $postLoadHandler) {
                        call_user_func_array($postLoadHandler, [$className]);
                    }
                }
                return;
            }
        }
    }

    public function unregister()
    {
        spl_autoload_unregister([$this, 'resolveClass']);
    }
}