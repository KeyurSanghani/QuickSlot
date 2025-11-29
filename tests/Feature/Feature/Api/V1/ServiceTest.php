<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('authenticated user can view all services', function () {
    Service::factory()->count(5)->create();

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/services');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => ['id', 'name', 'duration', 'price', 'is_active'],
                ],
            ],
        ]);
});

test('can get only active services publicly', function () {
    Service::factory()->active()->count(3)->create();
    Service::factory()->inactive()->count(2)->create();

    $response = $this->getJson('/api/v1/services/active');

    $response->assertStatus(200);

    $services = $response->json('data');
    expect(count($services))->toBe(3);

    foreach ($services as $service) {
        expect($service['is_active'])->toBeTrue();
    }
});

test('authenticated user can view single service', function () {
    $service = Service::factory()->create([
        'name' => 'Test Service',
        'price' => 100.00,
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/services/'.encryption($service->id));

    $response->assertStatus(200)
        ->assertJsonPath('data.name', 'Test Service')
        ->assertJsonPath('data.price', 100.00);
});

test('authenticated user can create a service', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/services', [
            'name' => 'New Service',
            'description' => 'Service description',
            'duration' => 60,
            'price' => 150.00,
            'is_active' => true,
        ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('services', [
        'name' => 'New Service',
        'duration' => 60,
        'price' => 150.00,
    ]);
});

test('validates required fields for service creation', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/services', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'name',
            'duration',
            'price',
        ]);
});

test('authenticated user can update a service', function () {
    $service = Service::factory()->create([
        'name' => 'Original Name',
        'price' => 100.00,
    ]);

    $response = $this->actingAs($this->user)
        ->putJson('/api/v1/services/'.encryption($service->id), [
            'name' => 'Updated Name',
            'description' => $service->description,
            'duration' => $service->duration,
            'price' => 200.00,
            'is_active' => $service->is_active,
        ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('services', [
        'id' => $service->id,
        'name' => 'Updated Name',
        'price' => 200.00,
    ]);
});

test('authenticated user can toggle service status', function () {
    $service = Service::factory()->active()->create();

    $response = $this->actingAs($this->user)
        ->patchJson('/api/v1/services/'.encryption($service->id).'/status');

    $response->assertStatus(200);

    $service->refresh();
    expect($service->is_active)->toBeFalse();
});

test('authenticated user can delete a service', function () {
    $service = Service::factory()->create();

    $response = $this->actingAs($this->user)
        ->deleteJson('/api/v1/services/'.encryption($service->id));

    $response->assertStatus(200);

    $this->assertSoftDeleted('services', [
        'id' => $service->id,
    ]);
});

test('validates price is numeric', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/services', [
            'name' => 'Test Service',
            'duration' => 60,
            'price' => 'invalid',
            'is_active' => true,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['price']);
});

test('validates duration is numeric', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/services', [
            'name' => 'Test Service',
            'duration' => 'invalid',
            'price' => 100.00,
            'is_active' => true,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['duration']);
});
