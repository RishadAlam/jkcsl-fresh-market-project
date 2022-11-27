<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Role
        $roleDeveloper = Role::create(['name' => 'ডেভেলপার']);
        $roleSuperAdmin = Role::create(['name' => 'প্রধান নির্বাহী']);
        $roleAdmin = Role::create(['name' => 'এডমিন']);
        $roleUser = Role::create(['name' => 'মার্কেটিং অফিসার']);

        // Permission
        $permissions = [
            // Dashboard
            [
                'groupName' => 'ড্যাশবোর্ড',
                'permissions' => [
                    'ড্যাশবোর্ড অ্যাডমিন'
                ]
            ],
            // Card Sale
            [
                'groupName' => 'কার্ড বিক্রয়',
                'permissions' => [
                    'কার্ড বিক্রয়',
                    'কার্ড অফিসার নির্বাচন',
                    'কার্ড ইডিট',
                    'কার্ড ডিলিট',
                    'কার্ড অনুমোদন',
                    'কার্ড বিক্রয় প্রতিবেদন',
                    'কার্ড বিক্রয় প্রতিবেদন ইডিট',
                    'কার্ড বিক্রয় প্রতিবেদন ডিলিট',
                    'কার্ড বিক্রয় তামাদি'
                ]
            ],
            // Service Sale
            [
                'groupName' => 'সার্ভিস বিক্রয়',
                'permissions' => [
                    'সার্ভিস বিক্রয়',
                    'সার্ভিস অফিসার নির্বাচন',
                    'সার্ভিস ইডিট',
                    'সার্ভিস ডিলিট',
                    'সার্ভিস বিক্রয় প্রতিবেদন'
                ]
            ],
            // Stock Management 
            [
                'groupName' => 'স্টক ম্যানেজমেন্ট',
                'permissions' => [
                    'স্টক',
                    'স্টক রেজিস্ট্রেশন',
                    'স্টক ইডিট',
                    'স্টক ডিলিট'
                ]
            ],
            // Category Management 
            [
                'groupName' => 'ক্যাটাগরি ম্যানেজমেন্ট',
                'permissions' => [
                    'ক্যাটাগরি',
                    'ক্যাটাগরি রেজিস্ট্রেশন',
                    'ক্যাটাগরি ইডিট',
                    'ক্যাটাগরি ডিলিট'
                ]
            ],
            // Officer Management 
            [
                'groupName' => 'অফিসার ম্যানেজমেন্ট',
                'permissions' => [
                    'অফিসার',
                    'অফিসার রেজিস্ট্রেশন',
                    'অফিসার ইডিট',
                    'অফিসার স্ট্যাটাস পরিবর্তন'
                ]
            ],
            // Salery Management 
            [
                'groupName' => 'বেতন শিট',
                'permissions' => [
                    'কার্ড বিক্রয় রিপোর্ট',
                    'বেতন ফরম'
                ]
            ],
            // Expence Management 
            [
                'groupName' => 'ব্যয়',
                'permissions' => [
                    'ব্যয়',
                    'ব্যয় রেজিস্ট্রেশন',
                    'ব্যয় ইডিট',
                    'ব্যয় ডিলিট',
                    'অফিসার দৈনিক ব্যয়',
                    'অফিসার দৈনিক ব্যয় অফিসার নির্বাচন',
                ]
            ],
            // Role Management 
            [
                'groupName' => 'পদবি এবং অনুমতি',
                'permissions' => [
                    'পদবি এবং অনুমতি',
                    'পদবি এবং অনুমতি রেজিস্ট্রেশন',
                    'পদবি এবং অনুমতি ইডিট'
                ]
            ],
            // Accounts management
            [
                'groupName' => 'হিসাব',
                'permissions' => [
                    'হিসাব',
                    'শেয়ার হিসাব',
                ]
            ],
            // Settings
            [
                'groupName' => 'সেটিংস',
                'permissions' => [
                    'সেটিংস'
                ]
            ]

        ];

        foreach ($permissions as $row) {
            $groupName = $row['groupName'];
            foreach ($row['permissions'] as $permission) {
                $permission = Permission::create(['name' => $permission, 'group' => $groupName]);
                $roleDeveloper->givePermissionTo($permission);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
                $permission->assignRole($roleDeveloper);
            }
        }
    }
}
