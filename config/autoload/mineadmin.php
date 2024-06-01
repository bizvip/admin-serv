<?php

declare(strict_types=1);

return [
    // 是否启用数据权限
    'data_scope_enabled' => true,
    /*
     * excel 导入、导出驱动类型 auto, xlsWriter, phpOffice
     * auto 优先使用xlsWriter，若环境没有安装xlsWriter扩展则使用phpOffice
     */
    'excel_drive'        => 'auto',
    // 是否启用 远程通用列表查询 功能
    'remote_api_enabled' => true,
    'http'               => [
        'headers' => [
            'Server' => 'MineAdmin',
        ],
    ],
];
