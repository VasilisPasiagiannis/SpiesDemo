<?php

use App\Domains\Agencies\Models\AgencyEnum;
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
        Schema::create('spies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('surname');
            $table->enum('agency', AgencyEnum::values());
            $table->string('country_of_operation');
            $table->date('birthday');
            $table->date('deathday')->nullable();

            $table->timestamps();

            $table->unique(['name', 'surname']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spies');
    }
};
