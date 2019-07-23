<?php
/**
 * @author Denysaw
 */
use App\Models\Items;
use Yarak\DB\Seeders\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    factory(Items::class, 1000)->create();
    }
}
