<?php

use App\Constants\DatabaseTables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $usersTableName = DatabaseTables::USERS->value;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->usersTableName, function (Blueprint $table) {
            $table->renameColumn('id', 'firebase_uid');
            $table->dropPrimary('users_id_primary');
            $table->bigIncrements('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->usersTableName, function (Blueprint $table) {
            $table->dropColumn('id');
            $table->renameColumn('firebase_uid', 'id');
            $table->primary('id');
        });
    }
};
