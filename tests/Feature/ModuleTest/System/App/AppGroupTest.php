<?php

declare(strict_types=1);

use App\System\Model\SystemAppGroup;
use Hyperf\Stringable\Str;

beforeEach(function () {
    $this->prefix = '/system/appGroup';
});

test('App Group get test', function () {
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'index',
        $this->buildTest('getNoParamsTest') => 'list',
        $this->buildTest('getNoParamsTest') => 'recycle',
    ]);
    $this->remoteTest();
});

test('App Group put test', function () {
    $successParam = [
        'name' => Str::random(5),
    ];
    $failParams = [
        [],
    ];
    $updateSuccessParam = [
        'name' => Str::random(5),
    ];
    $updateFailParams = [
        [],
    ];
    expect($this->prefix)->toBeSaveAndUpdate($successParam, $failParams, $updateSuccessParam, $updateFailParams);
    $id = SystemAppGroup::query()->value('id');
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'read/' . $id,
    ]);
    $this->recoveryAndDeleteTest([$id]);
});
