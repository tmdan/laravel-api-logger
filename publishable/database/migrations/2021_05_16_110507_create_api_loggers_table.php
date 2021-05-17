<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_loggers', function (Blueprint $table) {
            $table->id();
            $table->string('request_full_url');
            $table->string('request_method');
            $table->json('request_body')->nullable();
            $table->json('request_header')->nullable();
            $table->string('request_ip')->nullable();
            $table->string('request_agent')->nullable();
            $table->json('response_content')->nullable();
            $table->integer('response_status_code')->nullable();
            $table->string('user_timezone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_loggers');
    }
}
