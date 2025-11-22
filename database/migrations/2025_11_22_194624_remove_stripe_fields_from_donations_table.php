<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Remove Stripe-specific columns
            $table->dropColumn(['stripe_payment_intent_id', 'stripe_charge_id']);
        });

        // Update payment_method enum to remove 'stripe' and 'card' options
        DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method ENUM('paypal') DEFAULT 'paypal'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Restore Stripe-specific columns
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_charge_id')->nullable();
        });

        // Restore original payment_method enum
        DB::statement("ALTER TABLE donations MODIFY COLUMN payment_method ENUM('paypal', 'stripe', 'card') DEFAULT 'paypal'");
    }
};
