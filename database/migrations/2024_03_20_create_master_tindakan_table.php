<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_tindakan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tindakan', 20)->unique();
            $table->string('nama_tindakan');
            $table->decimal('harga', 10, 2);
            $table->text('keterangan')->nullable();
            $table->string('jenis_tindakan')->nullable();
            $table->string('group_tindakan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_tindakan');
    }
}; 