<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pyamentMethods = [
            [
                'name' => 'PayPal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MasterCard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Visa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        PaymentMethod::insert($pyamentMethods);
    }
}
