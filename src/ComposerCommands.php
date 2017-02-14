<?php

namespace App;

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ComposerCommands
{
    public static function run(array $inputArray)
    {
        // from http://stackoverflow.com/a/25208897/3133038

        $output = new BufferedOutput;

        // It defaults to /home/$user/.composer
        // Still works if the directory is not writable... No caching though
        putenv('COMPOSER_HOME=' . __DIR__ . '/../vendor/bin/composer');

        // Build command programmatically
        $input = new ArrayInput($inputArray);
        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script
        $returnCode = $application->run($input, $output);

        // from http://stackoverflow.com/a/20808687/3133038

        if ($returnCode !== 0) {
            throw new Exception('Command failed');
        }

        return $output->fetch();
    }

    public static function require($package)
    {
        return self::run([
            'command' => 'require',
            'packages' => [$package],
        ]);
    }

    public static function remove($package)
    {
        return self::run([
            'command' => 'remove',
            'packages' => [$package],
        ]);
    }

    public function dumpautoload()
    {
        return self::run([
            'command' => 'dump-autoload',
        ]);
    }

    public function update()
    {
        return self::run([
            'command' => 'update',
        ]);
    }
}
