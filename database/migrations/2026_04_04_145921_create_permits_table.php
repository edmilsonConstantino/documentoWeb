<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('reference')->unique();
            $table->string('document_type')->default('Permit');
            $table->string('client_name');
            $table->string('nuit')->nullable();
            $table->string('vehicle_registration')->nullable();
            $table->string('vehicle_brand')->nullable();
            $table->string('cargo_type')->nullable();
            $table->string('capacity')->nullable();
            $table->string('origin')->nullable();
            $table->json('transit_countries')->nullable();
            $table->date('issued_at');
            $table->date('expires_at');
            $table->enum('status', ['valid', 'expired', 'cancelled'])->default('valid');
            $table->string('validation_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permits');
    }
}
