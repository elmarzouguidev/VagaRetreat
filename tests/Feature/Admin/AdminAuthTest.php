<?php

use App\Enums\Roles\RolesEnums;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => RolesEnums::SUPERADMIN->value]);
    Role::firstOrCreate(['name' => RolesEnums::CLIENT->value]);
});

test('guest is redirected from admin dashboard to login', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('non-admin user cannot access admin dashboard', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnums::CLIENT);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('superadmin can access admin dashboard', function () {
    $admin = User::factory()->create();
    $admin->assignRole(RolesEnums::SUPERADMIN);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('superadmin can log in via admin login form', function () {
    $admin = User::factory()->create([
        'email' => 'admin@vagaretreat.test',
        'password' => bcrypt('password123'),
    ]);
    $admin->assignRole(RolesEnums::SUPERADMIN);

    $response = $this->post(route('admin.login.post'), [
        'email' => 'admin@vagaretreat.test',
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('non-superadmin cannot log in via admin login form', function () {
    $client = User::factory()->create([
        'email' => 'client@vagaretreat.test',
        'password' => bcrypt('password123'),
    ]);
    $client->assignRole(RolesEnums::CLIENT);

    $response = $this->post(route('admin.login.post'), [
        'email' => 'client@vagaretreat.test',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
