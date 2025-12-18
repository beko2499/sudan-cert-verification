<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الصلاحيات
        $permissions = [
            'view certificates',
            'create certificates',
            'edit certificates',
            'delete certificates',
            'manage universities',
            'view logs',
            'export data',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // إنشاء دور المسؤول (Admin)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // إنشاء دور مسؤول الجامعة
        $universityAdmin = Role::firstOrCreate(['name' => 'university_admin']);
        $universityAdmin->givePermissionTo([
            'view certificates',
            'create certificates',
            'edit certificates',
            'view logs',
            'export data',
        ]);

        // إنشاء دور المتحقق
        $verifier = Role::firstOrCreate(['name' => 'verifier']);
        $verifier->givePermissionTo(['view certificates']);

        // إنشاء مستخدم admin تجريبي
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@mohe.gov.sd'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
        $adminUser->assignRole('admin');

        $this->command->info('✅ تم إنشاء الأدوار والصلاحيات بنجاح!');
    }
}