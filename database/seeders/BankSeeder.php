<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            [
                'name' => 'saderat',
                'pattern' => '11'
            ],
            [
                'name' => 'melat',
                'pattern' => '12'
            ],
            [
                'name' => 'maskan',
                'pattern' => '13'
            ],
        ];

        foreach($banks as $bank){
            Bank::create([
                'name' => $bank['name'],
                'pattern' => $bank['pattern'],
            ]);
        }
    }
}
