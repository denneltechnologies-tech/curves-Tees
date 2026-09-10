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
            if (!Schema::hasColumn('users', 'preferred_size')) {
                $table->string('preferred_size')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('preferred_size');
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'notes')) {
                $table->text('notes')->nullable()->after('city');
            }
        });

        Schema::table('customer_leads', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_leads', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('order_id')->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['preferred_size', 'address', 'city', 'notes']);
        });

        Schema::table('customer_leads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
