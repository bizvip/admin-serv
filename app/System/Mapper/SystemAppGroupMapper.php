<?php

declare(strict_types=1);

namespace App\System\Mapper;

use App\System\Model\SystemAppGroup;
use Hyperf\Database\Model\Builder;
use Mine\Abstracts\AbstractMapper;

/**
 * Class SystemAppGroupMapper.
 */
class SystemAppGroupMapper extends AbstractMapper
{
    /**
     * @var SystemAppGroup
     */
    public $model;

    public function assignModel(): void
    {
        $this->model = SystemAppGroup::class;
    }

    /**
     * 搜索处理器.
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        // 应用组名称
        if (isset($params['name']) && filled($params['name'])) {
            $query->where('name', '=', $params['name']);
        }

        // 状态
        if (isset($params['status']) && filled($params['status'])) {
            $query->where('status', '=', $params['status']);
        }

        return $query;
    }
}
