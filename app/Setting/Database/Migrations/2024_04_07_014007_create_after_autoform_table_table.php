<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

class CreateAfterAutoformTableTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('setting_generate_columns', function (Blueprint $table) {
            Schema::hasColumn('setting_generate_columns', 'extra') || $table->addColumn('string', 'extra', [
                'length'  => 255,
                'comment' => '字段扩展信息',
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting_generate_columns', function (Blueprint $table) { });
    }
}
