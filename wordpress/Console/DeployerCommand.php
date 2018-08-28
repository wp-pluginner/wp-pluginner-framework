<?php

namespace WpPluginner\Wordpress\Console;

use WpPluginner\Illuminate\Support\Arr;
use WpPluginner\Illuminate\Support\Str;
use WpPluginner\Illuminate\Console\Command;

class DeployerCommand extends Command
{
    protected $signature = 'plugin:deploy {name=export}';

    protected $description = 'Deploy plugin to production.';

    protected $config;

    protected $name;
    protected $files = [];

    public function handle()
    {
        $this->name = $this->argument('name');
        $this->basePath = wp_pluginner_base_path();
        $this->files = wp_pluginner('files');

        $this->config = wp_pluginner_config('deployer');

        $this->deployPath = wp_pluginner_base_path('production/' . $this->name . time());
        $this->processDirectory($this->basePath);
        $this->processIncludes();
    }

    protected function processDirectory($path)
    {
        if ($this->files->isDirectory($path) && $this->isFileOrDirInclude($path)) {
            if ($this->isRequireDepth($path)) {
                $files = $this->files->glob($path . '/{,.}[!.,!..]*', GLOB_BRACE);
                foreach ($files as $file) {
                    if ($this->files->isFile($file)) {
                        $this->processFile($file);
                    } else {
                        $this->processDirectory($file);
                    }
                }
            } else {
                if ($this->files->isFile($path)) {
                    $this->copyFile($path);
                } else {
                    $this->copyDirectory($path);
                }
            }
        }
    }

    protected function copyFile($path)
    {
        $source = $path;
        $target = Str::replaceFirst($this->basePath, $this->deployPath, $path);
        $this->files->copy($source, $target);
    }

    protected function copyDirectory($path)
    {
        $source = $path;
        $target = Str::replaceFirst($this->basePath, $this->deployPath, $path);
        $this->files->copyDirectory($source, $target);
    }

    protected function processIncludes()
    {
        if (is_array($this->config['includes'])) {
            foreach ($this->config['includes'] as $include) {
                if ($this->files->exists($include)) {
                    if ($this->files->isFile($include)) {
                        $this->processFile($include);
                    } else {
                        $this->processDirectory($include);
                    }
                }
            }
        }
    }

    protected function processFile($path)
    {
        if ($this->files->isFile($path) && $this->isFileOrDirInclude($path)) {
            $this->copyFile($path);
        }
    }

    protected function isFileOrDirInclude($path)
    {
        if (is_array($this->config['excludes'])) {
            if(in_array($path, $this->config['excludes'])) {
                return false;
            }
        }
        return true;
    }

    protected function isRequireDepth($path)
    {
        if (is_array($this->config['excludes'])) {
            foreach ($this->config['excludes'] as $exclude) {
                if (Str::contains($this->files->dirname($exclude), $path)) {
                    return true;
                }
            }
        }
        return false;
    }
}
