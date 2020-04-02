<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reported_by')->unsigned();
            $table->integer('product_id')->unsigned()->nullable();
            $table->string('priority')->nullable();
            $table->string('version_resolved')->nullable();
            $table->string('status')->nullable();
            $table->string('issue_type')->nullable();
            $table->text('attributes');
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
        Schema::drop('issues');
    }
}
