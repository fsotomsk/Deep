<?php
/**
 * Project: cDeep
 * File: Helper.php
 * User: fso
 * Date: 16.01.2014
 * Description:
 */

namespace Deep\Autoconf;


trait Helper
{
    /**
     * @var array $autoConfig
     */
    public static $autoConfig = [];

    protected function extendConfig(array $config)
    {
        self::$autoConfig = array_merge($config, self::$autoConfig);
        return self::$autoConfig;
    }

}