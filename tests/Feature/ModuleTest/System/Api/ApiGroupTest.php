<?php

declare(strict_types=1);

use App\System\Model\SystemApiGroup;
use Hyperf\Stringable\Str;

beforeEach(function () {
    $this->prefix = '/system/apiGroup';
});

test('Api Group get test', function () {
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'index',
        $this->buildTest('getNoParamsTest') => 'list',
        $this->buildTest('getNoParamsTest') => 'recycle',
    ]);
    $this->remoteTest();
});

test('Api Group put test', function () {
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
    $id = SystemApiGroup::query()->where('name', $updateSuccessParam['name'])->value('id');
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'read/' . $id,
    ]);

    $this->changeStatusTest($id);
    $this->recoveryAndDeleteTest([$id]);
});
