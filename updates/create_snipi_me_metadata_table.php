<?php 
namespace SNiPI\MEMetadata\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSnipiMeMetadataTable extends Migration
{

    public function up()
    {
        Schema::create('snipi_memetadata', function($table)
        {

            $table->bigIncrements('id');
            $table->string('title',250)->nullable();
            $table->string('keywords',250)->nullable();
            $table->string('filepath',250)->nullable();
            $table->longText('description')->nullable();  
            $table->string('source',250)->nullable();  
            $table->string('source_url',250)->nullable();  
            $table->string('author',250)->nullable();
            $table->string('author_url',250)->nullable();                        
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softdeletes();

        });
    }

    public function down()
	{
	    Schema::dropIfExists('snipi_memetadata');
	} 

}