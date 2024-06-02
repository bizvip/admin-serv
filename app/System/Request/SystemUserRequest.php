<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace App\System\Request;

use App\System\Service\SystemUserService;
use Mine\MineFormRequest;

class SystemUserRequest extends MineFormRequest
{
    /**
     * 公共规则.
     */
    public function commonRules(): array
    {
        return [];
    }

    /**
     * 新增数据验证规则
     * return array.
     */
    public function saveRules(): array
    {
        return [
            'username' => 'required|max:20',
            'password' => 'required|min:6',
            'phone' => 'phone_number',
            'email' => 'email',
            'dept_ids' => 'required',
            'role_ids' => 'required',
            'remark' => 'max:255',
        ];
    }

    /**
     * 更新数据验证规则
     * return array.
     */
    public function updateRules(): array
    {
        return [
            'username' => 'required|max:20',
            'phone' => 'phone_number',
            'email' => 'email',
            'dept_ids' => 'required',
            'role_ids' => 'required',
            'remark' => 'max:255',
        ];
    }

    /**
     * 修改状态数据验证规则
     * return array.
     */
    public function changeStatusRules(): array
    {
        return [
            'id' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * 修改密码验证规则
     * return array.
     */
    public function modifyPasswordRules(): array
    {
        return [
            'newPassword' => 'required|confirmed|string',
            'newPassword_confirmation' => 'required|string',
            'oldPassword' => [
                'required',
                function ($attribute, $value, $fail) {
                    $service = $this->container->get(SystemUserService::class);
                    /* @var SystemUser $model */
                    $model = $service->mapper->getModel()::find((int) user()->getId(), ['password']);
                    if (! $service->mapper->checkPass($value, $model->password)) {
                        $fail(t('system.valid_password'));
                    }
                },
            ],
        ];
    }

    /**
     * 设置用户首页数据验证规则.
     */
    public function setHomePageRules(): array
    {
        return [
            'id' => 'required',
            'dashboard' => 'required',
        ];
    }

    /**
     * 登录规则.
     * @return string[]
     */
    public function loginRules(): array
    {
        return [
            'username' => 'required|max:20',
            'password' => 'required|min:6',
        ];
    }

    /**
     * 更改用户资料验证规则.
     */
    public function updateInfoRules(): array
    {
        return [
            'username' => 'max:20',
            'phone' => 'phone_number',
            'email' => 'email',
            'signed' => 'max:255',
        ];
    }

    /**
     * 字段映射名称
     * return array.
     */
    public function attributes(): array
    {
        return [
            'id' => '用户ID',
            'username' => '用户名',
            'password' => '用户密码',
            'dashboard' => '用户后台首页',
            'oldPassword' => '旧密码',
            'newPassword' => '新密码',
            'newPassword_confirmation' => '确认密码',
            'status' => '用户状态',
            'dept_ids' => '部门ID',
            'role_ids' => '角色列表',
            'phone' => '手机',
            'email' => '邮箱',
            'remark' => '备注',
            'signed' => '个人签名',
        ];
    }
}
