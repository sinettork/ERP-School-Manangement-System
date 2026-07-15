<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\SchoolInformation;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ១. បង្កើតតួនាទីទាំង ៨
        $roles = [
            'super-admin',   // គ្រប់គ្រងទាំងអស់
            'admin',         // អ្នកគ្រប់គ្រងសាលា
            'principal',     // នាយក
            'teacher',       // គ្រូបង្រៀន
            'staff',         // បុគ្គលិក
            'accountant',    // គណនេយ្យករ
            'student',       // សិស្ស
            'parent',        // អាណាព្យាបាល
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // ២. បង្កើតសិទ្ធិ
        $permissions = [
            // School
            'view school info', 'edit school info',
            // Academic Years
            'view academic years', 'create academic years', 'edit academic years', 'delete academic years',
            // Students
            'view students', 'create students', 'edit students', 'delete students',
            // Teachers
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            // Classes
            'view classes', 'create classes', 'edit classes', 'delete classes',
            // Subjects
            'view subjects', 'create subjects', 'edit subjects', 'delete subjects',
            // Attendance
            'view attendance', 'record attendance',
            // Exams & Scores
            'view exams', 'create exams', 'edit exams', 'delete exams',
            'view scores', 'enter scores', 'edit scores',
            // Report Cards
            'view report cards', 'generate report cards', 'delete report cards',
            // Payments
            'view payments', 'create payments', 'edit payments', 'delete payments',
            // Finance
            'view finance', 'manage finance',
            // Staff
            'view staff', 'create staff', 'edit staff', 'delete staff',
            // Library
            'view library', 'manage library',
            // Announcements
            'view announcements', 'create announcements',
            // Inventory
            'view inventory', 'manage inventory',
            // Settings
            'view settings', 'manage settings',
            // Users
            'view users', 'create users', 'edit users', 'delete users',
            // Roles
            'view roles', 'manage roles',
            // Activity logs
            'view activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ៣. កំណត់សិទ្ធិឲ្យតួនាទី
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->syncPermissions(Permission::all());

        $admin = Role::findByName('admin');
        $admin->syncPermissions(Permission::whereNotIn('name', [
            'manage roles', 'delete users',
        ])->get());

        $principal = Role::findByName('principal');
        $principal->syncPermissions([
            'view school info',
            'view academic years',
            'view students', 'view teachers', 'view classes', 'view subjects',
            'view attendance', 'view exams', 'view scores', 'view report cards',
            'view payments', 'view finance',
            'view staff', 'view announcements', 'create announcements',
            'view library', 'view inventory', 'view activity logs',
        ]);

        $teacherRole = Role::findByName('teacher');
        $teacherRole->syncPermissions([
            'view students', 'view classes', 'view subjects',
            'view attendance', 'record attendance',
            'view exams', 'view scores', 'enter scores', 'edit scores',
            'view report cards', 'generate report cards',
            'view announcements',
            'view library',
        ]);

        $staffRole = Role::findByName('staff');
        $staffRole->syncPermissions([
            'view students', 'view announcements',
            'view library', 'manage library',
            'view inventory',
        ]);

        $accountant = Role::findByName('accountant');
        $accountant->syncPermissions([
            'view students',
            'view payments', 'create payments', 'edit payments',
            'view finance', 'manage finance',
            'view announcements',
        ]);

        Role::findByName('student')->syncPermissions([
            'view announcements',
            'view scores', 'view report cards',
            'view attendance',
        ]);

        Role::findByName('parent')->syncPermissions([
            'view announcements',
            'view scores', 'view report cards',
            'view attendance', 'view payments',
        ]);

        // Create an initial owner only when deployment credentials are explicitly supplied.
        $initialAdminEmail = env('SEED_SUPER_ADMIN_EMAIL');
        $initialAdminPassword = env('SEED_SUPER_ADMIN_PASSWORD');

        if ($initialAdminEmail && $initialAdminPassword) {
            $superAdminUser = User::firstOrCreate(
                ['email' => $initialAdminEmail],
                [
                    'name' => env('SEED_SUPER_ADMIN_NAME', 'Super Administrator'),
                    'password' => Hash::make($initialAdminPassword),
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );
            $superAdminUser->assignRole('super-admin');
            $superAdminUser->forceFill(['email_verified_at' => now(), 'status' => 'active'])->save();
        }

        // ៦. ព័ត៌មានសាលា
        SchoolInformation::firstOrCreate(
            ['id' => 1],
            [
                'school_name' => 'វិទ្យាល័យ គំរូ',
                'address'     => 'រាជធានីភ្នំពេញ ប្រទេសកម្ពុជា',
                'phone'       => '023 000 000',
                'email'       => 'info@school.edu.kh',
            ]
        );

        // ៧. ឆ្នាំសិក្សា
        AcademicYear::firstOrCreate(
            ['name' => '2025-2026'],
            [
                'start_date' => '2025-10-01',
                'end_date'   => '2026-07-31',
                'is_active'  => true,
            ]
        );

        // ៨. ការកំណត់ប្រព័ន្ធ
        $settings = [
            'app_name'         => 'ប្រព័ន្ធគ្រប់គ្រងសាលារៀន',
            'app_locale'       => 'km',
            'currency'         => 'KHR',
            'currency_symbol'  => '៛',
            'items_per_page'   => '15',
            'allow_student_login' => 'true',
            'allow_parent_login'  => 'true',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->command->info('Seeding completed.');
        if (! $initialAdminEmail || ! $initialAdminPassword) {
            $this->command->warn('No initial administrator was created. Set SEED_SUPER_ADMIN_EMAIL and SEED_SUPER_ADMIN_PASSWORD before seeding production.');
        }
    }
}
