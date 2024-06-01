<?php

declare(strict_types=1);

use Hyperf\Collection\Arr;

beforeEach(function () {
    $this->prefix = '/setting/datasource';
});

test('index test', function () {
    $result = $this->get($this->prefix . '/index');
    expect($result)->toBeHttpSuccess();
});

test('save test', function () {
    expect($this->post($this->prefix . '/save', []))->toBeHttpFail()
        ->and($this->post($this->prefix . '/save', [
            'source_name' => 'test',
        ]))->toBeHttpFail()
        ->and($this->post($this->prefix . '/save', [
            'source_name' => 'test',
            'dsn' => 'test',
            'username' => 'root',
        ]))->toBeHttpFail();
    $saveResult = $this->post($this->prefix . '/save', [
        'source_name' => 'currentData',
        'dsn' => 'test',
        'username' => 'root',
        'password' => 'root',
    ]);
    expect($saveResult)->toBeHttpSuccess()
        ->and($saveResult)->toHaveKey('data.id');
    $updateUri = $this->prefix . '/update/' . Arr::get($saveResult, 'data.id');
    expect($this->put($updateUri, []))->toBeHttpFail()
        ->and($this->put($updateUri, [
            'source_name' => 'test',
        ]))->toBeHttpFail()
        ->and($this->put($updateUri, [
            'source_name' => 'test',
            'dsn' => 'test',
            'username' => 'root',
        ]))->toBeHttpFail();
    $updateResult = $this->put($updateUri, [
        'source_name' => 'test',
        'dsn' => 'test',
        'username' => 'root',
        'password' => 'root',
    ]);
    expect($updateResult)->toBeHttpSuccess();
    $readResult = $this->get($this->prefix . '/read/' . Arr::get($saveResult, 'data.id'));
    expect($readResult)->toBeHttpSuccess()
        ->and($readResult['data']['id'])->toEqual(Arr::get($saveResult, 'data.id'))
        ->and($this->delete($this->prefix . '/delete'))->toBeHttpFail()
        ->and($this->delete($this->prefix . '/delete', ['ids' => [Arr::get($saveResult, 'data.id')]]))->toBeHttpSuccess();
});

test('getDataSourceTablePageList test', function () {
    expect($this->get($this->prefix . '/getDataSourceTablePageList'))->toBeHttpSuccess();
});

test('remote test', function () {
    expect($this->post($this->prefix . '/remote'))->toBeHttpSuccess();
});
