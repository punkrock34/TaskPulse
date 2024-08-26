<?php

use App\Constants\DatabaseTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    private $usersTableName = DatabaseTables::USERS->value;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->usersTableName, function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->usersTableName, function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
