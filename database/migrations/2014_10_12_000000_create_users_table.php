<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',100);
            $table->string('last_name',100)->nullable();
            $table->string('email',64)->unique();
            $table->string('mobile_no',15)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('is_role',['1','2'])->default(2)->comment('1 = Admin, 2 = Developer');
            $table->enum('status', ['0','1'])->default('1')->comment('0 = Inactive, 1 = Active');
            $table->rememberToken();
            $table->integer('created_by')->default(0);
            $table->timestamps();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
