<?php namespace VictoryCms\Core\Seeders;

use Illuminate\Database\Seeder;
use VictoryCms\Core\Models\Hero;

/**
 * Class HeroSeeder.
 */
class HeroSeeder extends Seeder
{
    /**
     */
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
