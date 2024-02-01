<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();

            $table->longText('avatar')->nullable(); //can be null(empty)
            $table->string('password');
            $table->string('introduction', 100)->nullable();
            $table->integer('role_id')->default(2)->comment('1:admin,2:user');
            // default - default value when creating
            // $table->rememberToken();
            // 新しいデータがこのテーブルに追加されるとき、もしrole_idの値が指定されていない場合は、自動的に2が設定される。この場合、role_idは通常ユーザー（user）の役割を表しているようで、デフォルトで2に設定されているということです。
            // = 2user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
