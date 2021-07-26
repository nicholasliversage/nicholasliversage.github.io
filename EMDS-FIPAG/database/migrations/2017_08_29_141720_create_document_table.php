<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('category_id');
            $table->integer('depart_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('cliente_name');
            $table->string('file')->nullable();
            $table->string('filesize')->nullable();
            $table->string('mimetype')->nullable();;
            $table->boolean('isExpire')->default(0);
            $table->date('expires_at')->nullable();
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
        Schema::dropIfExists('document');
    }
}
