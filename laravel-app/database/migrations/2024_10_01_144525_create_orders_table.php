<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public const CURRENCY = ['twd', 'usd', 'jpy', 'rmb', 'myr'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("name")->comment("消費者名稱");
            $table->string("city")->comment("城市名稱");
            $table->string("district")->comment("行政區名稱");
            $table->string("street")->comment("街道名稱");
            $table->string("currency_type");
            $table->string("currency_id");
            $table->timestamps();
            $table->unique(["currency_type", "currency_id"]);
        });

        foreach (self::CURRENCY as $currency) {
            Schema::create('orders_' . $currency, function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger("price")->comment("訂單金額");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        foreach (self::CURRENCY as $currency) {
            Schema::dropIfExists('orders_' . $currency);
        }
    }
};
