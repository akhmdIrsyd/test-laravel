<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Program;

class ProgramTest extends TestCase
{
    use RefreshDatabase;
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
        ->assertStatus(401)
            ->assertJson([]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = User::factory()->create([
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    public function test_show_method_creates_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Program Test',
            'desc' => 'Description of the program.',
        ];

        $response = $this->getJson('/api/programs', $data);

        $response->assertStatus(200);
    }


    public function test_store_method_creates_program_without_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'input',
            'desc' => 'Description of the program.',
        ];
        
        $response = $this->postJson('/api/programs');

        $response->assertStatus(200);
           

    }

    public function test_update_method_updates_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $program = Program::factory()->create(['id_user' => $user->id]);

        $data = [
            'name' => 'Updated Program Name',
            'desc' => 'Updated program description.',
        ];

        $response = $this->putJson("/api/programs/{$program->id}", $data);

        $response->assertStatus(200)
            ->assertJson([]);
    }

    public function test_update_method_returns_404_for_nonexistent_program()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $nonexistentProgramId = 999;

        $data = [
            'name' => 'Updated Program Name',
            'desc' => 'Updated program description.',
        ];

        $response = $this->putJson("/api/programs/{$nonexistentProgramId}", $data);

        $response->assertStatus(404);
    }
}

