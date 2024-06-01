<?php

declare(strict_types=1);

use Nette\Utils\FileSystem;

test('common test', function () {
    FileSystem::delete(BASE_PATH . '/app/Demo');
    $result = $this->get('/setting/common/getModuleList');
    expect($result)->toBeHttpSuccess()
        ->and($result['data'])
        ->toHaveCount(2);
});
