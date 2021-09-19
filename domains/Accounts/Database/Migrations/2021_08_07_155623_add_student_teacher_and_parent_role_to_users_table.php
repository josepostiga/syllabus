<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStudentTeacherAndParentRoleToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            $table->enum('new_role', [
                'DIRECTOR',
                'HEADTEACHER',
                'PARENT',
                'STUDENT',
                'TEACHER',
            ])->nullable();
        });

        DB::update('UPDATE users SET new_role = role');

        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', static function (Blueprint $table) {
            $table->renameColumn('new_role', 'role');
        });

        DB::raw('ALTER TABLE users ALTER COLUMN role SET NOT NULL');
    }
}
