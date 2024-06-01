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
use App\Setting\Model\SettingConfigGroup;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class SettingConfigGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Db::table('setting_config_group')->truncate();
        $data = [
            [
                'name' => '站点配置',
                'code' => 'site_config',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => '上传配置',
                'code' => 'upload_config',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];
        foreach ($data as $value) {
            SettingConfigGroup::create($value);
        }
    }
}
