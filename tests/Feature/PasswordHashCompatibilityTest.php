<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordHashCompatibilityTest extends TestCase
{
    public function test_it_accepts_legacy_argon2id_password_hashes(): void
    {
        $hash = password_hash('correct-password', PASSWORD_ARGON2ID);

        $this->assertFalse(config('hashing.bcrypt.verify'));
        $this->assertTrue(Hash::check('correct-password', $hash));
        $this->assertFalse(Hash::check('incorrect-password', $hash));
    }
}
