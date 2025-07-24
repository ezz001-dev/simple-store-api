<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Nonaktifkan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);

        // Aktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
    }
}
