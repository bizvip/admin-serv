<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemApi;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemApiMapper.
 */
class SystemApiMapper extends AbstractMapper
{
    /**
     * @var SystemApi
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemApi::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query;
    }

    /**
     * 通过api获取字段列表.
     */
    public function getColumnListByApiId(string $id): array
    {
        return $this->model::query()->where('id', $id)->with([
            'apiColumn' => function ($query) {
                $query->where('status', $this->model::ENABLE);
            },
        ])->first()->toArray();
    }
}
