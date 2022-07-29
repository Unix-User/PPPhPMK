<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('key')->nullable()
                ->nullable()
                ->after('mode');
            $table->string('token')->nullable()
                ->nullable()
                ->after('mode');
            $table->string('test_key')->nullable()
                ->nullable()
                ->after('mode');
            $table->string('test_token')->nullable()
                ->nullable()
                ->after('mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('key');
            $table->dropColumn('token');
            $table->dropColumn('test_key');
            $table->dropColumn('test_token');
        });
    }
};
