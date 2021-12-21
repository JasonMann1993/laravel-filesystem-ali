<?php

namespace Jasonmann\LaravelFilesystem\Ali;


use Illuminate\Support\ServiceProvider;
use Jasonmann\Flysystem\Aliyun\OssAdapter;
use Jasonmann\Flysystem\Aliyun\Plugins\FileUrl;
use Jasonmann\Flysystem\Aliyun\Plugins\Kernel;
use Jasonmann\Flysystem\Aliyun\Plugins\SignatureConfig;
use Jasonmann\Flysystem\Aliyun\Plugins\SignUrl;
use Jasonmann\Flysystem\Aliyun\Plugins\TemporaryUrl;
use League\Flysystem\Filesystem;

class AliStorageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('filesystem')->extend('ali',function($app, $config){
            $adapter = new OssAdapter(
                $config['access_key'],
                $config['secret_key'],
                $config['endpoint'],
                $config['bucket'],
                $config['isCName'],
                $config['root']
            );

            $filesystem = new Filesystem($adapter);

            $filesystem->addPlugin(new FileUrl());
            $filesystem->addPlugin(new Kernel());
            $filesystem->addPlugin(new SignatureConfig());
            $filesystem->addPlugin(new SignUrl());
            $filesystem->addPlugin(new TemporaryUrl());

            return $filesystem;
        });
    }

    public function register()
    {

    }
}