<?php

declare(strict_types=1);

use App\System\Model\SystemUploadfile;
use Hyperf\Stringable\Str;

beforeEach(function () {
    $this->prefix = '/system/attachment';
});

test('attachment test', function () {
    $file = SystemUploadfile::create([
        'storage_mode' => 1,
        'origin_name' => 'xxx',
        'object_name' => 'xxx',
        'hash' => Str::random(32),
        'mime_type' => 1,
        'storage_path' => 'xxxx',
        'suffix' => 'xxxx',
        'size_byte' => 2,
        'size_info' => 'xxxx',
        'url' => 'xxxxx',
        'remark' => 'xxxxx',
    ]);
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'recycle',
        $this->buildTest('getNoParamsTest') => 'index',
    ]);
    $this->remoteTest();

    $this->recoveryAndDeleteTest([$file->id]);
});
