<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DokumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokuments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_uploaders')->constrained('uploaders');
            $table->foreignId('id_revisis')->nullable()->constrained('revisis');
            $table->foreignId('id_users')->nullable()->constrained('users');
            $table->integer('hapus')->default(1);
            $table->string('dokumen')->nullable();
            $table->string('status_dokumen')->nullable();
            $table->string('url_dokumen');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
