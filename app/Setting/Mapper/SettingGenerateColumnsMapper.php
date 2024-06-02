<?php

declare(strict_types=1);

namespace App\Setting\Mapper;

use App\Setting\Model\SettingGenerateColumns;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * 生成业务字段信息表查询类
 * Class SettingGenerateColumnsMapper.
 */
class SettingGenerateColumnsMapper extends AbstractMapper
{
    /**
     * @var SettingGenerateColumns
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = SettingGenerateColumns::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if ($params['table_id'] ?? false) {
            $query->where('table_id', (int)$params['table_id']);
        }

        return $query;
    }
}
