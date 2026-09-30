<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => 'admin@jajan2.com']);
        $admin->name = 'Admin Jajan';
        $admin->password = Hash::make('admin123');
        $admin->email_verified_at = now();
        $admin->save();

        $foods = [
            ['name' => 'Nasi Goreng Spesial', 'price' => 18000, 'description' => 'Nasi goreng gurih dengan telur, ayam suwir, dan sayuran segar.', 'category' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Mie Ayam Chili Oil', 'price' => 16000, 'description' => 'Mie kenyal, ayam berbumbu, dan chili oil racikan dapur Jajan.', 'category' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Rice Bowl Teriyaki', 'price' => 22000, 'description' => 'Ayam teriyaki lembut dengan nasi hangat dan taburan wijen.', 'category' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Es Kopi Gula Aren', 'price' => 14000, 'description' => 'Kopi susu dingin dengan manis gula aren yang pas.', 'category' => 'Minuman', 'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Lemon Tea', 'price' => 10000, 'description' => 'Teh segar dengan perasan lemon dan es batu.', 'category' => 'Minuman', 'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=900&q=80'],
            ['name' => 'Pisang Goreng Keju', 'price' => 12000, 'description' => 'Pisang manis renyah dengan keju dan susu kental manis.', 'category' => 'Cemilan', 'image' => 'https://images.unsplash.com/photo-1626074353765-517a681e40be?auto=format&fit=crop&w=900&q=80'],
        ];

        foreach ($foods as $food) {
            Food::updateOrCreate(['name' => $food['name']], $food);
        }
    }
}
