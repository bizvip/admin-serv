<?php

declare(strict_types=1);

beforeEach(function () {
    $this->prefix = '/system/server';
});

test('monitor test', function () {
    if (is_in_container()) {
        expect($this->get($this->prefix . '/monitor'))->toBeHttpFail();
    } else {
        expect($this->get($this->prefix . '/monitor'))->toBeHttpSuccess();
    }
});
