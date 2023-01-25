<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UploadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploaders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_projeks')->nullable()->constrained('projeks');
            $table->foreignId('id_checker')->nullable()->constrained('users');
            $table->foreignId('id_drafter')->nullable()->constrained('users');
            $table->integer('hapus')->default(1);
            $table->string('judul');
            $table->string('drawing_number');
            $table->string('status')->default("Empty");
            $table->string('rev')->default('0');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
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
