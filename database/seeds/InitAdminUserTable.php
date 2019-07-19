<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class InitAdminUserTable extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
        ['account' => 'ddfgadmin'],
        [
            'account'  => 'ddfgadmin',
            'level'    => 0,
            'password' => '$2y$10$40NCryO2D3/3RYF09bmPE.nsaTjYhGKVuuzGfufgUvG5ZUfmrCmhG',
            'nickname' => 'company1',
            'parents'  => '[]',
            'status'   => 'normal',
            'role'     => 'agent',
            'api_key'  => 'a25e66c7d865702cc45f394f9e8af2b4a381eed7'
        ]);
    }
}
