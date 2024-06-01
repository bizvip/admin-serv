<?php

declare(strict_types=1);

use App\System\Model\SystemUser;

beforeEach(function () {
    $this->prefix = '/system/dataMaintain';
    $this->tables = [SystemUser::getModel()->getTable()];
});

test('DataMaintain test', function () {
    $this->actionTest([
        $this->buildTest('getNoParamsTest') => 'index',
        $this->buildTest('getNoParamsTest') => 'detailed',
    ]);
});

test('optimize tables test', function () {
    expect($this->post($this->prefix . '/optimize', [
        'tables' => $this->tables,
    ]))->toBeHttpSuccess();
});

test('fragment tables test', function () {
    expect($this->post($this->prefix . '/fragment', [
        'tables' => $this->tables,
    ]))->toBeHttpSuccess();
});
