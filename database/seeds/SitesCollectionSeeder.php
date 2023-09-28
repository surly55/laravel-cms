<?php

use Illuminate\Database\Seeder;

class SitesCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::collection('sites')->delete();

        factory(App\Models\Site::class, 10)->create();
    }
}