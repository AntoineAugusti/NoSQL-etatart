<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('LocationTableSeeder');
        $this->call('RecipeTableSeeder');
        $this->call('GuestTableSeeder');
        $this->call('EventTableSeeder');
    }
}
