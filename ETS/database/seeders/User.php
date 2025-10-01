<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.gudang@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'gudang',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.gudang@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'gudang', // Diubah dari 'gudang'
            ],
            [
                'name' => 'Rahmat Hidayat',
                'email' => 'rahmat.gudang@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'gudang', // Diubah dari 'gudang'
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina.gudang@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'gudang', // Diubah dari 'gudang'
            ],
            [
                'name' => 'Anton Saputra',
                'email' => 'anton.gudang@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'gudang', // Diubah dari 'gudang'
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.dapur@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'dapur', // Diubah dari 'dapur'
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.dapur@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'dapur', // Diubah dari 'dapur'
            ],
            [
                'name' => 'Maria Ulfa',
                'email' => 'maria.dapur@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'dapur', // Diubah dari 'dapur'
            ],
            [
                'name' => 'Surya Kurnia',
                'email' => 'surya.dapur@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'dapur', // Diubah dari 'dapur'
            ],
            [
                'name' => 'Yanti Fitri',
                'email' => 'yanti.dapur@mbg.id',
                'password' => Hash::make('pass123'),
                'role' => 'dapur', // Diubah dari 'dapur'
            ],
        ]);
    }
}
