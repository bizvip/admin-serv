<?php

declare(strict_types=1);

use App\Setting\Model\SettingConfigGroup;
use Hyperf\Stringable\Str;

beforeEach(function () {
    $this->prefix = '/setting/configGroup';
});
test('config group controller', function () {
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'index',
    ]);
    $this->remoteTest();
    expect($this->post($this->prefix . '/save', [
        'name' => Str::random(3),
        'code' => Str::random(4),
    ]))->toBeHttpSuccess();
    $id = SettingConfigGroup::query()->first()->value('id');
    expect($this->delete($this->prefix . '/delete', compact('id')))->toBeHttpSuccess();
});
