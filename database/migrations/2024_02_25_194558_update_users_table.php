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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password_changed_at', function (Blueprint $table) {
                $table->string('employee_id')->nullable();
                $table->foreignId('department_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
                $table->foreignId('designation_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
                $table->date('date_hired')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id', 'designation_id']);
            $table->dropColumn(['employee_id', 'department_id', 'designation_id']);
        });
    }
};
