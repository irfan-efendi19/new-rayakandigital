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
        Schema::create('affiliate_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->decimal('commission_rate', 5, 2);
            $table->timestamps();
        });
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->restrictOnDelete();
            $table->foreignId('affiliate_tier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('business_name', 150);
            $table->string('partner_type', 30);
            $table->string('phone', 25);
            $table->string('status', 20)->default('pending')->index();
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->string('bank_name', 100);
            $table->text('bank_account_number');
            $table->string('bank_account_holder', 150);
            $table->text('review_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->restrictOnDelete();
            $table->string('slug', 60)->unique();
            $table->string('label', 100);
            $table->string('destination', 30)->default('home');
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->foreignId('affiliate_id')->nullable()->unique()->constrained()->restrictOnDelete();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('affiliate_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('affiliate_link_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('affiliate_commission_rate', 5, 2)->nullable();
        });
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->restrictOnDelete();
            $table->foreignId('order_id')->unique()->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('sale_amount');
            $table->decimal('rate', 5, 2);
            $table->unsignedBigInteger('amount');
            $table->string('status', 20)->default('earned');
            $table->timestamps();
            $table->index(['affiliate_id', 'status']);
        });
        Schema::create('affiliate_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('amount');
            $table->string('status', 20)->default('pending');
            $table->string('bank_name', 100);
            $table->text('bank_account_number');
            $table->string('bank_account_holder', 150);
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('review_note')->nullable();
            $table->string('transfer_reference', 150)->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['affiliate_id', 'status']);
        });
        Schema::create('marketing_assets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('category', 30);
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::table('system_configs', function (Blueprint $table) {
            $table->decimal('affiliate_commission_rate', 5, 2)->default(10);
            $table->decimal('affiliate_discount_rate', 5, 2)->default(5);
            $table->unsignedBigInteger('affiliate_minimum_payout')->default(50000);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_configs', fn (Blueprint $table) => $table->dropColumn([
            'affiliate_commission_rate', 'affiliate_discount_rate', 'affiliate_minimum_payout',
        ]));
        Schema::dropIfExists('marketing_assets');
        Schema::dropIfExists('affiliate_payouts');
        Schema::dropIfExists('affiliate_commissions');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('affiliate_id');
            $table->dropConstrainedForeignId('affiliate_link_id');
            $table->dropColumn('affiliate_commission_rate');
        });
        Schema::table('promotions', fn (Blueprint $table) => $table->dropConstrainedForeignId('affiliate_id'));
        Schema::dropIfExists('affiliate_links');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('affiliate_tiers');
    }
};
