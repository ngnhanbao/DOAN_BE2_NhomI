<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $vouchers = [];

        /*
        |--------------------------------------------------------------------------
        | SHIPPING VOUCHERS
        |--------------------------------------------------------------------------
        */
        for($i = 1; $i <= 10; $i++){

            $vouchers[] = [

                'code' => 'SHIP' . ($i * 10) . 'K',

                'type' => 'shipping',

                'value' => $i * 10000,

                'min_order_value' => 100000 * $i,

                'max_discount' => null,

                'usage_limit' => 100,

                'used_count' => 0,

                'is_active' => 1,

                'start_at' => Carbon::now(),

                'end_at' => Carbon::now()->addMonths(2),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PERCENT VOUCHERS
        |--------------------------------------------------------------------------
        */
        for($i = 1; $i <= 10; $i++){

            $vouchers[] = [

                'code' => 'SALE' . ($i * 5),

                'type' => 'percent',

                'value' => $i * 5,

                'min_order_value' => 200000 * $i,

                'max_discount' => 50000 * $i,

                'usage_limit' => 100,

                'used_count' => 0,

                'is_active' => 1,

                'start_at' => Carbon::now(),

                'end_at' => Carbon::now()->addMonths(2),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | FIXED VOUCHERS
        |--------------------------------------------------------------------------
        */
        for($i = 1; $i <= 10; $i++){

            $vouchers[] = [

                'code' => 'GIAM' . ($i * 50) . 'K',

                'type' => 'fixed',

                'value' => $i * 50000,

                'min_order_value' => 300000 * $i,

                'max_discount' => null,

                'usage_limit' => 100,

                'used_count' => 0,

                'is_active' => 1,

                'start_at' => Carbon::now(),

                'end_at' => Carbon::now()->addMonths(2),
            ];
        }

        DB::table('vouchers')->insert(
            $vouchers
        );
    }
}