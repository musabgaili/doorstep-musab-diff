<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use App\Models\VisitRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // get all aparmtents ass aray , get id only
        $apartments = Apartment::all()->pluck('id')->toArray();
        // get all users who is client ass aray , get id only
        $users = User::where('user_type', 'client')->get()->pluck('id')->toArray();
        // create 1000 visit requests
        for ($i = 0; $i < 1000; $i++) {
            # code...
            VisitRequest::create([
                'apartment_id' => $apartments[array_rand($apartments)],
                'user_id' => $users[array_rand($users)],
                'requested_at' => now(),
                'status' => 'pending',
            ]);
        }
    }
}
