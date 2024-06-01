<?php

declare(strict_types=1);

use App\System\Model\SystemQueueMessage;

beforeEach(function () {
    $this->prefix = '/system/queueMessage';
});
test('queue message test', function () {
    if (! in_array(env('DB_DRIVER'), ['pgsql', 'mysql'], true)) {
        return;
    }
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'receiveList',
        $this->buildTest('getNoParamsTest') => 'sendList',
        $this->buildTest('getNoParamsTest') => 'getReceiveUser',
    ]);
});

test('update read status', function () {
    $ids = array_column(SystemQueueMessage::query()->select(['id'])->get()->toArray(), 'id');

    expect($this->put($this->prefix . '/updateReadStatus', [
        'ids' => $ids,
    ]))->toBeHttpSuccess();
});
