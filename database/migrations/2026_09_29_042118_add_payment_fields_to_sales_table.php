<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('payment_type', ['contado', 'credito'])->default('contado')->after('total');
            $table->date('due_date')->nullable()->after('payment_type')->comment('Fecha de vencimiento');
            $table->decimal('paid_amount', 10, 2)->default(0)->after('due_date')->comment('Monto pagado');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'due_date', 'paid_amount']);
        });
    }
};