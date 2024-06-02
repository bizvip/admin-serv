<?php

declare(strict_types=1);
use App\Setting\Model\SettingCrontab;
use Hyperf\Database\Seeders\Seeder;

class SettingCrontabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        SettingCrontab::truncate();
        SettingCrontab::create([
            'name' => 'urlCrontab',
            'type' => '3',
            'target' => 'http://127.0.0.1:9501/',
            'parameter' => '',
            'rule' => '59 */1 * * * *',
            'singleton' => 2,
            'status' => 2,
            'created_by' => 0,
            'updated_by' => 0,
            'created_at' => '2021-08-07 23:28:28',
            'updated_at' => '2021-08-07 23:44:55',
            'remark' => '请求127.0.0.1',
        ]);
        SettingCrontab::create([
            'name' => '每月1号清理所有日志',
            'type' => '2',
            'target' => 'App\System\Crontab\ClearLogCrontab',
            'parameter' => '',
            'rule' => '0 0 0 1 * *',
            'singleton' => 2,
            'status' => 2,
            'created_by' => 0,
            'updated_by' => 0,
            'created_at' => '2022-04-11 11:15:48',
            'updated_at' => '2022-04-11 11:15:48',
            'remark' => '',
        ]);
    }
}
