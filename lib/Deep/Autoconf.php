<?php
/**
 * Project: cDeep
 * User: fso
 * Date: 07.11.2014
 * Time: 18:15
 * Description: Auto-configuration
 */

namespace Deep;

/**
 * Class Autoconf
 * @package Deep
 */
class Autoconf
{

    use Autoconf\Helper;

    private $cacheConfigs = [];
    private $iniPaths     = [];

    /**
     * Autoconf constructor.
     * @param array $paths
     */
    public function __construct($paths)
    {
        $this->iniPaths = array_unique($paths);
    }

    /**
     * @param string $className
     * @return array
     */
    public function readConfig($className)
    {
        if (array_key_exists($className, $this->cacheConfigs)) {
            return $this->cacheConfigs[$className];
        }
        if ($className[0] == '/') {
            $className = substr($className, 1);
        }
        foreach ($this->iniPaths as $path) {
            $fileName = $path . $className . '.ini';
            if (file_exists($fileName)) {
                $iniConfig = parse_ini_file($fileName, true);
                $this->cacheConfigs[$className] = $iniConfig;
                return $iniConfig;
            }
        }
        return [];
    }

    /**
     * @param string $className
     * @return array
     */
    public function configureObject($className)
    {
        if (property_exists($className, 'autoConfig')) {
            $Ini = $this->readConfig(str_replace(['\\'], ['/'], $className));
            if ($Ini) {
                $className::$autoConfig = $Ini;
            }
            return $Ini;
        }
        return [];
    }

}