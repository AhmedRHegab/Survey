<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role_create',
            'role_edit',
            'role_access',

            'user_create',
            'user_edit',
            'user_status',
            'user_access',


            'general_add',


            'building_add',


            'safeSecurity_add',


            'step_access',
            'step_create',
            'step_edit',

            'group_access',
            'group_create',
            'group_edit',

            'question_access',
            'question_create',
            'question_edit',

            'statics_access',

            'survey_access',
            'survey_edit'


        ];// End Permissions

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'users'

            ]);
        }
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'users'
        ]);

        foreach ($permissions as $permission) {
            $superAdmin->givePermissionTo($permission);
        }
    }
}
