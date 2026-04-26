<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Beneficiary;
use App\Models\DonationCase;
use App\Models\PrepaidCard;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        /* User::factory()->create([
            'fullName' => 'moad',
            'email' => 'moad@gmail.com',
        ]); */

        Admin::factory()->create([
            'fullName' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        // User::factory(10)->create();

        // Beneficiary::factory(30)->create();

        // $beneficiary = Beneficiary::all();

        // for ($i = 0; $i < 10; $i++) {
        //     DonationCase::factory()->create([
        //         'beneficiary_id' => $beneficiary->random()->id,
        //     ]);
        // }

        PrepaidCard::factory(10)->create();

        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}
