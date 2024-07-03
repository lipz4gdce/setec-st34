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
        //add is_subscribed, subscribe_started, and subscribe_ended
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_subscribed')->default(false)->after('is_admin');
            $table->string('subscription_plan')->nullable()->after('is_subscribed');
            $table->timestamp('currentPeriodStart')->nullable();
            $table->timestamp('currentPeriodEnd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //drop the up functions
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_subscribed');
            $table->dropColumn('subscription_plan');
            $table->dropColumn('currentPeriodEnd');
            $table->dropColumn('currentPeriodStart');
        });
    }
};
