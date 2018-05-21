<?php

namespace Adelf\Config;


use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class ConfigBag extends Repository
{
    public function __construct(array $items = [])
    {
        parent::__construct($items);
        $this->loadConfigurationFiles(env('CONFIGURATION_FILE_PATH'));
    }

    /**
     * Get the configuration files for the selected environment.
     *
     * @return array
     */
    protected function getConfigurationFiles()
    {
        $path = $this->configPath;

         if (! is_dir($path)) {
            return [];
        }

        $files = [];
        $phpFiles = Finder::create()->files()->name('*.php')->in($path)->depth(0);

        foreach ($phpFiles as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param string      $path
     */
    private function loadConfigurationFiles($path)
    {
        $this->configPath = $path;

        foreach ($this->getConfigurationFiles() as $fileKey => $path) {
            $this->set($fileKey, require $path);
        }

        foreach ($this->getConfigurationFiles() as $fileKey => $path) {
            $envConfig = require $path;

            foreach ($envConfig as $envKey => $value) {
                $this->set($fileKey.'.'.$envKey, $value);
            }
        }
    }
}