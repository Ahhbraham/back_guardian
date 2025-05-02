<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('crime_type');
            $table->dateTime('incident_date');
            $table->string('incident_location');
            $table->text('description');
            $table->json('attachments')->nullable();
            $table->string('witness_name')->nullable();
            $table->string('witness_contact')->nullable();
            $table->boolean('allow_contact')->default(false);
            $table->boolean('consent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}