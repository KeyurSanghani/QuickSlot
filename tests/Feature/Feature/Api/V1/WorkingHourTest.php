<?php

use App\Models\User;
use App\Models\WorkingHour;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('authenticated user can view all working hours', function () {
    WorkingHour::factory()->count(5)->create();

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/working-hours');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => ['id', 'day_of_week', 'start_time', 'end_time', 'is_active'],
                ],
            ],
        ]);
});

test('authenticated user can view single working hour', function () {
    $workingHour = WorkingHour::factory()->create([
        'day_of_week' => 1,
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/working-hours/'.encryption($workingHour->id));

    $response->assertStatus(200)
        ->assertJsonPath('data.day_of_week', 1)
        ->assertJsonPath('data.start_time', '09:00:00');
});

test('authenticated user can create working hours', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/working-hours', [
            'day_of_week' => 1,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'is_active' => true,
        ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('working_hours', [
        'day_of_week' => 1,
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
    ]);
});

test('validates required fields for working hour creation', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/working-hours', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'day_of_week',
            'start_time',
            'end_time',
        ]);
});

test('validates day of week is between 0 and 6', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/working-hours', [
            'day_of_week' => 7,
            'start_time' => '09:00',
            'end_time' => '17:00',
            'is_active' => true,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['day_of_week']);
});

test('validates end time is after start time', function () {
    $response = $this->actingAs($this->user)
        ->postJson('/api/v1/working-hours', [
            'day_of_week' => 1,
            'start_time' => '17:00',
            'end_time' => '09:00',
            'is_active' => true,
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['end_time']);
});

test('authenticated user can update working hours', function () {
    $workingHour = WorkingHour::factory()->create([
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
    ]);

    $response = $this->actingAs($this->user)
        ->putJson('/api/v1/working-hours/'.encryption($workingHour->id), [
            'day_of_week' => $workingHour->day_of_week,
            'start_time' => '10:00',
            'end_time' => '18:00',
            'is_active' => $workingHour->is_active,
        ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('working_hours', [
        'id' => $workingHour->id,
        'start_time' => '10:00:00',
        'end_time' => '18:00:00',
    ]);
});

test('authenticated user can toggle working hour status', function () {
    $workingHour = WorkingHour::factory()->create(['is_active' => true]);

    $response = $this->actingAs($this->user)
        ->patchJson('/api/v1/working-hours/'.encryption($workingHour->id).'/status');

    $response->assertStatus(200);

    $workingHour->refresh();
    expect($workingHour->is_active)->toBeFalse();
});

test('authenticated user can delete working hours', function () {
    $workingHour = WorkingHour::factory()->create();

    $response = $this->actingAs($this->user)
        ->deleteJson('/api/v1/working-hours/'.encryption($workingHour->id));

    $response->assertStatus(200);

    $this->assertSoftDeleted('working_hours', [
        'id' => $workingHour->id,
    ]);
});

test('can get working hours grouped by day', function () {
    // Create working hours for different days
    WorkingHour::factory()->create(['day_of_week' => 1]); // Monday
    WorkingHour::factory()->create(['day_of_week' => 1]); // Monday
    WorkingHour::factory()->create(['day_of_week' => 2]); // Tuesday

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/working-hours/grouped');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data',
        ]);
});

test('working hour has correct day name attribute', function () {
    $workingHour = WorkingHour::factory()->create(['day_of_week' => 1]);

    expect($workingHour->day_name)->toBe('Monday');
});

test('active scope filters active working hours', function () {
    WorkingHour::factory()->create(['is_active' => true]);
    WorkingHour::factory()->create(['is_active' => true]);
    WorkingHour::factory()->create(['is_active' => false]);

    $activeWorkingHours = WorkingHour::active()->get();

    expect($activeWorkingHours)->toHaveCount(2);
});

test('for day scope filters by day of week', function () {
    WorkingHour::factory()->count(2)->create(['day_of_week' => 1]);
    WorkingHour::factory()->create(['day_of_week' => 2]);

    $mondayHours = WorkingHour::forDay(1)->get();

    expect($mondayHours)->toHaveCount(2);
});
