<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_published_programs(): void
    {
        Program::factory()->create([
            'slug' => 'maternelle',
            'name' => 'Maternelle',
            'description' => 'Éveil et découverte',
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->getJson('/api/v1/programs');

        $response->assertOk()
            ->assertJsonPath('data.0.title', 'Maternelle')
            ->assertJsonPath('data.0.slug', 'maternelle');
    }
}
