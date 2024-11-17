<?php

use App\Domains\Agencies\Models\AgencyEnum;
use App\Domains\Spies\Models\Spy;

it('creates a spy successfully', function () {
    // Use the SpyFactory to create a spy
    $spy = Spy::factory()->create();

    // Assert that the spy is in the database
    expect($spy)->toBeInstanceOf(Spy::class);
    expect($spy->name)->not()->toBeEmpty();
    expect($spy->surname)->not()->toBeEmpty();
    expect($spy->agency)->toBeIn(AgencyEnum::cases());
    expect(\Carbon\Carbon::parse($spy->birthday)->isValid())->toBeTrue();
});

it('creates multiple spies', function () {
    // Create 5 spies using the factory
    $spies = Spy::factory()->count(10)->create();

    // Assert that 5 spies are in the database
    expect(Spy::count())->toBe(Spy::count());
});

it('creates a spy with a specific agency', function () {
    $spy = Spy::factory()->state([
        'agency' => 'MI6'
    ])->create();

    expect($spy->agency)->toBe(AgencyEnum::MI6);
});

it('creates a spy with a deathday', function () {
    $spy = Spy::factory()->state([
        'deathday' => now()->format('Y-m-d')
    ])->create();

    expect($spy->deathday)->format('Y-m-d')->toBe(now()->format('Y-m-d'));
});
