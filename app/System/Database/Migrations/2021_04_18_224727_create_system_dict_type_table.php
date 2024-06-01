<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateSystemDictTypeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_dict_type', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('字典类型表');
            $table->bigIncrements('id')->comment('主键');
            $table->addColumn('string', 'name', ['length' => 50, 'comment' => '字典名称'])
                ->nullable();
            $table->addColumn('string', 'code', ['length' => 100, 'comment' => '字典标示'])
                ->nullable();
            $table->addColumn('smallInteger', 'status', [
                'default' => 1,
                'comment' => '状态 (1正常 2停用)',
            ])->nullable();
            $table->addColumn('bigInteger', 'created_by', ['comment' => '创建者'])->nullable();
            $table->addColumn('bigInteger', 'updated_by', ['comment' => '更新者'])->nullable();
            $table->timestamps();
            $table->addColumn('timestamp', 'deleted_at', [
                'precision' => 0,
                'comment'   => '删除时间',
            ])->nullable();
            $table->addColumn('string', 'remark', ['length' => 255, 'comment' => '备注'])
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dict_type');
    }
}
