<?php

declare(strict_types=1);

beforeEach(function () {
    $this->prefix = '/system/onlineUser';
});

test('online user controller test', function () {
    expect($this->get($this->prefix . '/index'))->toBeHttpSuccess();
    $id = $this->mock->id;
    expect($this->post($this->prefix . '/kick', compact('id')))->toBeHttpSuccess();
});
