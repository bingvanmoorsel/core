<?php namespace VictoryCms\
use Illuminate\Database\Seeder;
use VictoryCms\Core\Models\Hero;

class VictoryDatabaseSeeder extends Seeder {

    public function run()
    {
        $this->call('HeroTableSeeder');
    }
}

class HeroTableSeeder extends Seeder
{
    public function run()
    {
        $admin = new Hero();
        $admin->first_name = 'Admin';
        $admin->last_name = '';
        $admin->email = 'test@admin.nl';
        $admin->password = 'tobattle';
        $admin->save();
    }
}