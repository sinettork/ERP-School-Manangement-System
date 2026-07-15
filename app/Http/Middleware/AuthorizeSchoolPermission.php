<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeSchoolPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->status !== 'active') {
            abort(403);
        }

        $route = $request->route()?->getName();

        if ($route === 'dashboard') {
            abort_unless($user->getAllPermissions()->isNotEmpty(), 403);

            return $next($request);
        }

        if (in_array($route, ['profile.edit', 'profile.update', 'profile.destroy'], true)) {
            return $next($request);
        }

        if (in_array($route, ['announcements.update', 'announcements.destroy'], true)) {
            $announcement = $request->route('announcement');

            abort_unless($user->hasRole(['super-admin', 'admin']) || $announcement?->posted_by === $user->id, 403);

            return $next($request);
        }

        $permissions = [
            'academic-years.index' => 'view academic years', 'academic-years.show' => 'view academic years',
            'academic-years.create' => 'create academic years', 'academic-years.store' => 'create academic years',
            'academic-years.edit' => 'edit academic years', 'academic-years.update' => 'edit academic years',
            'academic-years.destroy' => 'delete academic years',
            'subjects.index' => 'view subjects', 'subjects.show' => 'view subjects',
            'subjects.create' => 'create subjects', 'subjects.store' => 'create subjects',
            'subjects.edit' => 'edit subjects', 'subjects.update' => 'edit subjects', 'subjects.destroy' => 'delete subjects',
            'teachers.index' => 'view teachers', 'teachers.show' => 'view teachers',
            'teachers.create' => 'create teachers', 'teachers.store' => 'create teachers',
            'teachers.edit' => 'edit teachers', 'teachers.update' => 'edit teachers', 'teachers.destroy' => 'delete teachers',
            'classes.index' => 'view classes', 'classes.show' => 'view classes',
            'classes.create' => 'create classes', 'classes.store' => 'create classes',
            'classes.edit' => 'edit classes', 'classes.update' => 'edit classes', 'classes.destroy' => 'delete classes',
            'students.index' => 'view students', 'students.show' => 'view students',
            'students.create' => 'create students', 'students.store' => 'create students',
            'students.edit' => 'edit students', 'students.update' => 'edit students', 'students.destroy' => 'delete students',
            'attendance.index' => 'view attendance', 'attendance.report' => 'view attendance', 'attendance.store' => 'record attendance',
            'exams.index' => 'view exams', 'exams.create' => 'create exams', 'exams.store' => 'create exams',
            'exams.edit' => 'edit exams', 'exams.update' => 'edit exams', 'exams.destroy' => 'delete exams',
            'scores.index' => 'view scores', 'scores.store' => 'enter scores',
            'report-cards.index' => 'view report cards', 'report-cards.show' => 'view report cards', 'report-cards.destroy' => 'delete report cards',
            'payments.index' => 'view payments', 'payments.show' => 'view payments', 'payments.receipt' => 'view payments',
            'payments.create' => 'create payments', 'payments.store' => 'create payments',
            'payments.edit' => 'edit payments', 'payments.update' => 'edit payments', 'payments.destroy' => 'delete payments',
            'staff.index' => 'view staff', 'staff.show' => 'view staff', 'staff.create' => 'create staff',
            'staff.store' => 'create staff', 'staff.edit' => 'edit staff', 'staff.update' => 'edit staff', 'staff.destroy' => 'delete staff',
            'library.index' => 'view library', 'library.show' => 'view library', 'library.create' => 'manage library',
            'library.store' => 'manage library', 'library.edit' => 'manage library', 'library.update' => 'manage library', 'library.destroy' => 'manage library',
            'inventory.index' => 'view inventory', 'inventory.show' => 'view inventory', 'inventory.create' => 'manage inventory',
            'inventory.store' => 'manage inventory', 'inventory.edit' => 'manage inventory', 'inventory.update' => 'manage inventory', 'inventory.destroy' => 'manage inventory',
            'announcements.index' => 'view announcements', 'announcements.show' => 'view announcements',
            'announcements.create' => 'create announcements', 'announcements.store' => 'create announcements', 'announcements.edit' => 'create announcements',
            'users.index' => 'view users', 'users.show' => 'view users', 'users.create' => 'create users', 'users.store' => 'create users',
            'users.edit' => 'edit users', 'users.update' => 'edit users', 'users.destroy' => 'delete users',
            'settings.index' => 'view settings', 'settings.update' => 'manage settings',
        ];

        abort_unless(isset($permissions[$route]) && $user->can($permissions[$route]), 403);

        return $next($request);
    }
}
