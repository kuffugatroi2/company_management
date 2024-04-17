<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'code' => 'Globit15012015',
            'name' => 'Công ty TNHH Globits',
            'address' => 'Số 52 Ngõ 121 Thái Hà - Đống Đa - Hà nội',
        ]);

        Company::create([
            'code' => 'TVLuxury14012024',
            'name' => 'Công ty CP Nghiên cứu và phát triển VT Luxury',
            'address' => '86 Trần Phú - Ba Đình - Hà Nội',
        ]);
    }
}
