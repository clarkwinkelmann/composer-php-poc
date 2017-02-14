<?php

namespace App;

use Composer\Json\JsonFile;

class ComposerPackages
{
    public static function readfile()
    {
        $file = new JsonFile(__DIR__ . '/../composer.json');

        return $file->read();
    }

    public static function index()
    {
        return self::readfile()['require'];
    }
}
