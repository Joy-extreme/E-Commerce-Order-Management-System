<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    public function run()
    {
        $outlets = [
            ['name' => 'Barisal', 'location' => 'Barisal Division'],
            ['name' => 'Chittagong', 'location' => 'Chittagong Division'],
            ['name' => 'Dhaka', 'location' => 'Dhaka Division'],
            ['name' => 'Khulna', 'location' => 'Khulna Division'],
            ['name' => 'Mymensingh', 'location' => 'Mymensingh Division'],
            ['name' => 'Rajshahi', 'location' => 'Rajshahi Division'],
            ['name' => 'Sylhet', 'location' => 'Sylhet Division'],
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }
    }
}
