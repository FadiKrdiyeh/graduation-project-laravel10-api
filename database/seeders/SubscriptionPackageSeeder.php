<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionPackage = [
            [
                'name' => 'Test',
                'cost' => 100,
                'duration' => 10,
                'created_at' => now(),
                'updated_at' => now(),
                'payment_method_id' => 1,
            ],
            [
                'name' => 'Test2',
                'cost' => 150,
                'duration' => 15,
                'created_at' => now(),
                'updated_at' => now(),
                'payment_method_id' => 2,
            ],
            [
                'name' => 'Test3',
                'cost' => 250,
                'duration' => 25,
                'created_at' => now(),
                'updated_at' => now(),
                'payment_method_id' => 3,
            ],
        ];

        SubscriptionPackage::insert($subscriptionPackage);
    }
}
