<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table): void {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 32)->default('not_started');
            $table->date('due_on')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('created_app', 32)->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('updated_app', 32)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'status',
                'due_on',
                'deleted_at',
                'created_by',
                'created_app',
                'updated_by',
                'updated_app',
            ]);
        });
    }
};
