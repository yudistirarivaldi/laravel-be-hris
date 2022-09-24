<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Team;
use App\Models\Role;
use App\Models\Responsibility;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Running Seeder

        // \App\Models\User::factory(10)->create(); //di dapat dari UserFactory.php
        // Company::factory(10)->create();
        // Team::factory(30)->create();
        // Role::factory(10)->create();
        // Responsibility::factory(10)->create();
        // Employee::factory(10)->create();
    }
}
