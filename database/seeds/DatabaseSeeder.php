<?php

use App\Models\Alert;
use App\Models\AlertComment;
use App\Models\AlertUpdate;
use App\Models\City;
use App\Models\User;
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
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);

        // Generate dummy data

        // Users
        /*$users = factory(User::class, 20)->create();
        $users->each(function ($user) {
            $user->assignRole('user');
        });*/

        // Cities
//        factory(City::class, 20)->create();
        // Alerts
        /*$alerts = factory(Alert::class, 50)->create();
        $alerts->each(function ($alert) {
            // alert updates
            factory(AlertUpdate::class, 10)->create([
                'alert_id' => $alert->id
            ]);
            // Alert Comments
            factory(AlertComment::class, 10)->create([
                'alert_id' => $alert->id
            ]);
        });*/
    }
}
