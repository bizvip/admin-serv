<?php

declare(strict_types=1);
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SystemDeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run()
    {
        Db::table('system_dept')->truncate();
        Db::table('system_dept')->insert(
            [
                'parent_id' => 0,
                'level' => '0',
                'name' => '曼艺科技',
                'leader' => '曼艺',
                'phone' => '16888888888',
                'created_by' => env('SUPER_ADMIN', 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        );
    }
}
