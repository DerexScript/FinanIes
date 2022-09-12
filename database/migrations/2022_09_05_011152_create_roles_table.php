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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->unique();
            $table->unsignedBigInteger("permission_id");
            $table->foreign("permission_id")->references("id")->on("permissions");
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
        Schema::create('roles', function (Blueprint $table) {
            $table->dropForeign('roles_permission_id_foreign');
        });
        Schema::dropIfExists('roles');
    }
};
