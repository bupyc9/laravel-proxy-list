<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'check_proxies',
            function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
                $table->unsignedInteger('proxy_id');
                $table->timestamp('checked_at')->nullable();
                $table->integer('status');
                $table
                    ->foreign('proxy_id')
                    ->references('id')
                    ->on('proxies')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('check_proxies');
    }
}
