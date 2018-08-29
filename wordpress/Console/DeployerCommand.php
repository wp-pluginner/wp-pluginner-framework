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


        $this->deployPath = wp_pluginner_base_path('production/' . $this->name);
        if ($this->files->exists($this->deployPath)) {
            $this->error('Name already used, please check directory: production/' . $this->name);
        } else {
            $this->files->makeDirectory($this->deployPath, 0777, true);

            $this->processCopyDirectory($this->basePath);
            $this->processCopyIncludes();

            if (is_array($this->config['rename']) && !empty($this->config['rename'])) {
                $rename = $this->config['rename'];
                $this->config['rename'] = [
                    'from' => array_keys($rename),
                    'to' => array_values($rename)
                ];
                $this->processRenameDirectory($this->deployPath);
            }
            $composerUpdate = 'cd ' . $this->deployPath . ' && composer dump-autoload';
            exec($composerUpdate);

        }
    }

    protected function processRenameDirectory($path)
    {
        if ($this->files->isDirectory($path)) {
            $files = $this->files->glob($path . '/{,.}[!.,!..]*', GLOB_BRACE);
            foreach ($files as $file) {
                if ($this->files->isFile($file)) {
                    $this->processRenameFile($file);
                } else {
                    $this->processRenameDirectory($file);
                }
            }
        }
    }

    protected function processRenameFile($path)
    {
        if ($this->files->exists($path) && $this->files->isFile($path)) {
            $content = $this->files->get($path);
            $content = str_replace($this->config['rename']['from'], $this->config['rename']['to'], $content);
            $this->files->put($path, $content);
        }
    }

    protected function processCopyDirectory($path)
    {
        if ($this->files->isDirectory($path) && $this->isFileOrDirIncludeForCopy($path)) {
            if ($this->isRequireDepthForCopy($path)) {
                $files = $this->files->glob($path . '/{,.}[!.,!..]*', GLOB_BRACE);
                foreach ($files as $file) {
                    if ($this->files->isFile($file)) {
                        $this->processCopyFile($file);
                    } else {
                        $this->processCopyDirectory($file);
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
        if ($this->files->exists($path) && $this->files->isFile($path)) {
            $target = Str::replaceFirst($this->basePath, $this->deployPath, $path);
            $dir = $this->files->dirname($target);
            if (!$this->files->exists($dir)) {
                $this->files->makeDirectory($dir, 0777, true);
            }
            $this->files->copy($path, $target);
        }
    }

    protected function copyDirectory($path)
    {
        if ($this->files->exists($path) && $this->files->isDirectory($path)) {
            $target = Str::replaceFirst($this->basePath, $this->deployPath, $path);
            $this->files->copyDirectory($path, $target);
        }
    }

    protected function processCopyIncludes()
    {
        if (is_array($this->config['files']['includes'])) {
            foreach ($this->config['files']['includes'] as $include) {
                if ($this->files->isFile($include)) {
                    $this->processCopyFile($include);
                } else {
                    $this->processCopyDirectory($include);
                }
            }
        }
    }

    protected function processCopyFile($path)
    {
        if ($this->isFileOrDirIncludeForCopy($path)) {
            $this->copyFile($path);
        }
    }

    protected function isFileOrDirIncludeForCopy($path)
    {
        if (is_array($this->config['files']['excludes'])) {
            if(in_array($path, $this->config['files']['excludes'])) {
                return false;
            }
        }
        return true;
    }

    protected function isRequireDepthForCopy($path)
    {
        if (is_array($this->config['files']['excludes'])) {
            foreach ($this->config['files']['excludes'] as $exclude) {
                if (Str::contains($this->files->dirname($exclude), $path)) {
                    return true;
                }
            }
        }
        return false;
    }
}
