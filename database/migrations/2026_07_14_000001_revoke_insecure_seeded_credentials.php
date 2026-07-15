<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->orderBy('id')->get(['id', 'password'])->each(function (object $user): void {
            if (Hash::check('Admin@1234', $user->password) || Hash::check('Teacher@1234', $user->password)) {
                DB::table('users')->where('id', $user->id)->update([
                    'password' => Hash::make(Str::random(64)),
                    'status' => 'inactive',
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        // Credential revocation is intentionally irreversible.
    }
};
