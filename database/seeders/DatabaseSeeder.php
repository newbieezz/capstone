<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
<<<<<<< Updated upstream
       // $this->call(AdminsTableSeeder::class);
=======
        //$this->call(AdminsTableSeeder::class);
>>>>>>> Stashed changes
       // $this->call(VendorsTableSeeder::class);
        //$this->call(VendoreBusinessDetailsTableSeeder::class);
       // $this->call(VendorsBankDetailsTableSeeder::class);
       //$this->call(SectionsTableSeeder::class);
<<<<<<< Updated upstream
       //$this->call(CategoryTableSeeder::class);
       //$this->call(BrandsTableSeeder::class);
=======
     $this->call(CategoryTableSeeder::class);
       $this->call(BrandsTableSeeder::class);
>>>>>>> Stashed changes
       //$this->call(ProductsTableSeeder::class);
       //$this->call(ProductsAttributesTableSeeder::class);
       //$this->call(BannersTableSeeder::class);
       //$this->call(FiltersTableSeeder::class);
        $this->call(FiltersValuesTableSeeder::class);
    }
}
