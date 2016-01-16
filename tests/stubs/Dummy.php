<?php

/**
 * Project: cDeep
 * File: Dummy.php
 * User: fso
 * Date: 26.11.2014
 * Time: 14:57
 * Description:
 */
class Dummy
{

    use Deep\Autoconf\Helper;

    public static $isLoaded = true;
    public $link     = null;
    public $error    = null;

    public function fetch_array() {
        return false;
    }

    public static function getInstance()
    {
        return new self();
    }

}