<?php

declare(strict_types=1);

use Hyperf\Context\ApplicationContext;
use Hyperf\Redis\Redis;

beforeEach(function () {
    $this->prefix = '/system/cache';
    $redis = ApplicationContext::getContainer()
        ->get(Redis::class);
    $redis->set('cache1', 1);
    $redis->expire('cache1', 100);
});

test('get monitor test', function () {
    expect($this->get($this->prefix . '/monitor'))->toBeHttpSuccess();
});

test('view test', function () {
    expect($this->post($this->prefix . '/view', [
        'key' => 'cache1',
    ]))->toBeHttpSuccess();
});

test('delete test', function () {
    expect($this->delete($this->prefix . '/delete', [
        'key' => 'cache1',
    ]))->toBeHttpSuccess();
});

test('clear test', function () {
    expect($this->delete($this->prefix . '/clear'))->toBeHttpSuccess();
});
