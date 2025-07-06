<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; 

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
  
        Admin::create([
            'first_name' => 'Sokpheng',
            'last_name' => 'Phon',
            'email' => 'sokpheng234@gmail.com',
            'password' => Hash::make('Admin123'), 
        ]);
    
    }
}
