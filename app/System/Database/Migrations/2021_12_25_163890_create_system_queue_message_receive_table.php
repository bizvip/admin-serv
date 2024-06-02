<?php

declare(strict_types=1);
use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateSystemQueueMessageReceiveTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_queue_message_receive', function (Blueprint $table) {
            $table->engine = 'Innodb';
            $table->comment('队列消息接收人表');
            $table->addColumn('bigInteger', 'message_id', [
                'unsigned' => true,
                'comment' => '队列消息主键',
            ]);
            $table->addColumn('bigInteger', 'user_id', [
                'unsigned' => true,
                'comment' => '接收用户主键',
            ]);
            $table->addColumn('smallInteger', 'read_status', [
                'default' => 1,
                'comment' => '已读状态 (1未读 2已读)',
            ])->nullable();
            $table->primary(['message_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_queue_message_receive');
    }
}
