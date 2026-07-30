<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Aws\S3\S3Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (config('app.env') === 'production' || env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Storage::extend('s3', function ($app, $config) {
            $s3Config = [
                'region' => $config['region'],
                'version' => 'latest',
                'endpoint' => $config['endpoint'] ?? null,
                'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
            ];

            if (!empty($config['token'])) {
                $s3Config['credentials']['token'] = $config['token'];
            }

            $client = new S3Client($s3Config);
            
            $adapter = new class($client, $config['bucket'], $config['root'] ?? '', null, null, $config['options'] ?? []) extends AwsS3V3Adapter {
                public function copy(string $source, string $destination, \League\Flysystem\Config $config): void
                {
                    try {
                        $content = $this->read($source);
                        $this->write($destination, $content, $config);
                    } catch (\Exception $e) {
                        throw \League\Flysystem\UnableToCopyFile::fromLocationToLocation($source, $destination, $e);
                    }
                }
            };

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
