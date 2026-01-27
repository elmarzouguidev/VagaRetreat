<?php

use App\Enums\Roles\RolesEnums;
use App\Models\User;

test('instructor role can be assigned to user', function () {
    \Spatie\Permission\Models\Role::create(['name' => RolesEnums::INSTRUCTOR->value]);

    $user = User::factory()->create([
        'bio' => 'Test Bio',
        'social_links' => ['facebook' => 'test'],
    ]);
    $user->assignRole(RolesEnums::INSTRUCTOR);

    $this->assertTrue($user->hasRole(RolesEnums::INSTRUCTOR));

    expect($user->hasRole(RolesEnums::INSTRUCTOR))->toBeTrue()
        ->and($user->bio)->toBe('Test Bio')
        ->and($user->social_links)->toBeArray()
        ->and($user->social_links['facebook'])->toBe('test');
});
