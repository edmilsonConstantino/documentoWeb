<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->string('document_file')->nullable()->after('validation_token');
            $table->string('document_original_name')->nullable()->after('document_file');
        });
    }

    public function down()
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn(['document_file', 'document_original_name']);
        });
    }
}
