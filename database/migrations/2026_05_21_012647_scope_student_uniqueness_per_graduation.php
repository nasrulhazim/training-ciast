<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['ic']);
            $table->dropUnique(['email']);

            $table->unique(['graduation_id', 'ic']);
            $table->unique(['graduation_id', 'email']);
            $table->unique(['graduation_id', 'matric_card']);
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['graduation_id', 'ic']);
            $table->dropUnique(['graduation_id', 'email']);
            $table->dropUnique(['graduation_id', 'matric_card']);

            $table->unique('ic');
            $table->unique('email');
        });
    }
};
