<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ActionType;
use App\Models\City;
use App\Models\Lead;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(10)->create();

/*         User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);*/

//        Lead::factory(100)->create();

/*        $states = [
            ['name' => 'Andhra Pradesh'],
            ['name' => 'Arunachal Pradesh'],
            ['name' => 'Assam'],
            ['name' => 'Bihar'],
            ['name' => 'Chhattisgarh'],
            ['name' => 'Goa'],
            ['name' => 'Gujarat'],
            ['name' => 'Haryana'],
            ['name' => 'Himachal Pradesh'],
            ['name' => 'Jharkhand'],
            ['name' => 'Karnataka'],
            ['name' => 'Kerala'],
            ['name' => 'Madhya Pradesh'],
            ['name' => 'Maharashtra'],
            ['name' => 'Manipur'],
            ['name' => 'Meghalaya'],
            ['name' => 'Mizoram'],
            ['name' => 'Nagaland'],
            ['name' => 'Odisha'],
            ['name' => 'Punjab'],
            ['name' => 'Rajasthan'],
            ['name' => 'Sikkim'],
            ['name' => 'Tamil Nadu'],
            ['name' => 'Telangana'],
            ['name' => 'Tripura'],
            ['name' => 'Uttar Pradesh'],
            ['name' => 'Uttarakhand'],
            ['name' => 'West Bengal'],
            ['name' => 'Andaman and Nicobar Islands'],
            ['name' => 'Chandigarh'],
            ['name' => 'Dadra & Nagar Haveli and Daman & Diu'],
            ['name' => 'Delhi'],
            ['name' => 'Jammu and Kashmir'],
            ['name' => 'Lakshadweep'],
            ['name' => 'Puducherry'],
            ['name' => 'Ladakh']
        ];

        foreach ($states as $key => $state) {
            State::create($state);
        }*/

        /*$cities = [
            ['name' => 'Amaravati', 'state_id' => '1'],
            ['name' => 'Visakhapatnam', 'state_id' => '1'],
            ['name' => 'Itanagar', 'state_id' => '2'],
            ['name' => 'Seppa', 'state_id' => '2'],
            ['name' => 'Dispur', 'state_id' => '3'],
            ['name' => 'Guwahati', 'state_id' => '3'],
            ['name' => 'Patna', 'state_id' => '4'],
            ['name' => 'Muzaffarpur', 'state_id' => '4']
        ];

        foreach ($cities as $key => $city) {
            City::create($city);
        }*/

        ActionType::factory(20)->create();

    }
}
