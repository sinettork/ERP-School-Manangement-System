<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SecurityControlsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_a_permission_cannot_access_student_records(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/students')->assertForbidden();
    }

    public function test_user_with_the_required_permission_can_access_student_records(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('view students', 'web'));

        $this->actingAs($user)->get('/students')->assertOk();
    }

    public function test_inactive_user_cannot_authenticate(): void
    {
        $user = User::factory()->create(['status' => 'inactive']);

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertGuest();
    }

    public function test_attendance_cannot_be_submitted_for_a_student_in_another_class(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::findOrCreate('record attendance', 'web'));
        $year = AcademicYear::create(['name' => '2026-2027', 'start_date' => '2026-01-01', 'end_date' => '2026-12-31']);
        $firstClass = SchoolClass::create(['name' => 'A', 'grade_level' => '1', 'shift' => 'morning', 'max_students' => 30, 'academic_year_id' => $year->id]);
        $secondClass = SchoolClass::create(['name' => 'B', 'grade_level' => '1', 'shift' => 'morning', 'max_students' => 30, 'academic_year_id' => $year->id]);
        $student = Student::create(['student_code' => 'STU-001', 'name_kh' => 'Test', 'gender' => 'male', 'class_id' => $secondClass->id, 'status' => 'active']);

        $response = $this->actingAs($user)->post('/attendance', [
            'class_id' => $firstClass->id,
            'date' => '2026-07-14',
            'statuses' => [$student->id => 'present'],
        ]);

        $response->assertSessionHasErrors('statuses');
        $this->assertDatabaseCount('attendances', 0);
    }
}
