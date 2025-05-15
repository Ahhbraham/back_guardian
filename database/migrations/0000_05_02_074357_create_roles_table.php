<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // bigIncrements, matches foreignId in users
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed the roles table
        $roles = [
            ['name' => 'User', 'slug' => 'user', 'description' => 'Standard user role'],
            ['name' => 'Police', 'slug' => 'police', 'description' => 'Police service role'],
            ['name' => 'Ambulance', 'slug' => 'ambulance', 'description' => 'Ambulance service role'],
            ['name' => 'FireServices', 'slug' => 'fire-services', 'description' => 'Fire services role'],
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Administrative role'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};