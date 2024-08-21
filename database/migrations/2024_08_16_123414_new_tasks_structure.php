<?php

use App\Constants\DatabaseTables;
use App\Constants\TaskPriority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tasksTableName = DatabaseTables::TASKS->value;

    private $usersTableName = DatabaseTables::USERS->value;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table($this->tasksTableName, function (Blueprint $table) {
            $table->timestamp('deadline')->nullable();

            $table->enum('priority', TaskPriority::values())->default(TaskPriority::MEDIUM->value);

            $table->timestamp('completed_at')->nullable();

            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');

            $table->bigInteger('user_id')->unsigned()->after('id');
            $table->foreign('user_id')->references('id')->on($this->usersTableName)->onDelete('cascade');

            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table($this->tasksTableName, function (Blueprint $table) {
            $table->dropColumn('deadline');
            $table->dropColumn('priority');
            $table->dropColumn('completed_at');
            $table->dropColumn('notes');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
