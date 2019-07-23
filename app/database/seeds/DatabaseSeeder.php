<?php

use Yarak\DB\Seeders\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $this->call(ItemSeeder::class);
    }
}
