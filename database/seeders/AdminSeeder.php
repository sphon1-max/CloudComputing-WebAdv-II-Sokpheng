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
            'Name' => 'KHEvent',
            'email' => 'admin@kh-events.local',
            'password' => Hash::make('admin123'), 
            
        ]);
    
    }
}
