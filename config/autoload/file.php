<?php

declare(strict_types=1);

use Hyperf\Filesystem\Adapter\AliyunOssAdapterFactory;
use Hyperf\Filesystem\Adapter\CosAdapterFactory;
use Hyperf\Filesystem\Adapter\FtpAdapterFactory;
use Hyperf\Filesystem\Adapter\LocalAdapterFactory;
use Hyperf\Filesystem\Adapter\MemoryAdapterFactory;
use Hyperf\Filesystem\Adapter\QiniuAdapterFactory;
use Hyperf\Filesystem\Adapter\S3AdapterFactory;

return [
    'default' => 'local',
    'storage' => [
        'local'  => [
            'driver' => LocalAdapterFactory::class,
            'root'   => __DIR__ . '/../../public/' . env('UPLOAD_PATH', 'uploadfile'),
        ],
        'oss'    => [
            'driver'       => AliyunOssAdapterFactory::class,
            'accessId'     => '',
            'accessSecret' => '',
            'bucket'       => '',
            'endpoint'     => '',
            'domain'       => '',
            'schema'       => 'http://',
            'isCName'      => false,
            // 'timeout'        => 3600,
            // 'connectTimeout' => 10,
            // 'token'          => '',
        ],
        'qiniu'  => [
            'driver'    => QiniuAdapterFactory::class,
            'accessKey' => '',
            'secretKey' => '',
            'bucket'    => '',
            'domain'    => '',
            'schema'    => 'http://',
        ],
        'cos'    => [
            'driver'        => CosAdapterFactory::class,
            'region'        => '',
            'domain'        => '',
            'schema'        => 'http://',
            'app_id'        => env('COS_APPID'),
            'secret_id'     => env('COS_SECRET_ID'),
            'secret_key'    => env('COS_SECRET_KEY'),
            // 可选，如果 bucket 为私有访问请打开此项
            // 'signed_url' => false,
            'bucket'        => '',
            'read_from_cdn' => false,
            // 'timeout'         => 60,
            // 'connect_timeout' => 60,
            // 'cdn'             => '',
            // 'scheme'          => 'https',
        ],
        'ftp'    => [
            'driver'   => FtpAdapterFactory::class,
            'host'     => 'ftp.example.com',
            'username' => 'username',
            'password' => 'password',
            // 'port' => 21,
            // 'root' => '/path/to/root',
            // 'passive' => true,
            // 'ssl' => true,
            // 'timeout' => 30,
            // 'ignorePassiveAddress' => false,
        ],
        'memory' => [
            'driver' => MemoryAdapterFactory::class,
        ],
        's3'     => [
            'driver'                  => S3AdapterFactory::class,
            'credentials'             => [
                'key'    => env('S3_KEY'),
                'secret' => env('S3_SECRET'),
            ],
            'region'                  => env('S3_REGION'),
            'version'                 => 'latest',
            'bucket_endpoint'         => false,
            'use_path_style_endpoint' => false,
            'endpoint'                => env('S3_ENDPOINT'),
            'bucket_name'             => env('S3_BUCKET'),
        ],
        'minio'  => [
            'driver'                  => S3AdapterFactory::class,
            'credentials'             => [
                'key'    => env('S3_KEY'),
                'secret' => env('S3_SECRET'),
            ],
            'region'                  => env('S3_REGION'),
            'version'                 => 'latest',
            'bucket_endpoint'         => false,
            'use_path_style_endpoint' => true,
            'endpoint'                => env('S3_ENDPOINT'),
            'bucket_name'             => env('S3_BUCKET'),
        ],
    ],
];
