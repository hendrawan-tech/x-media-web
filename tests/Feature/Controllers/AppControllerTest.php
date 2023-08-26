<?php

namespace Tests\Feature\Controllers;

use App\Models\App;
use App\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_apps(): void
    {
        $apps = App::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('apps.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.apps.index')
            ->assertViewHas('apps');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_app(): void
    {
        $response = $this->get(route('apps.create'));

        $response->assertOk()->assertViewIs('app.apps.create');
    }

    /**
     * @test
     */
    public function it_stores_the_app(): void
    {
        $data = App::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('apps.store'), $data);

        $this->assertDatabaseHas('apps', $data);

        $app = App::latest('id')->first();

        $response->assertRedirect(route('apps.edit', $app));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_app(): void
    {
        $app = App::factory()->create();

        $response = $this->get(route('apps.show', $app));

        $response
            ->assertOk()
            ->assertViewIs('app.apps.show')
            ->assertViewHas('app');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_app(): void
    {
        $app = App::factory()->create();

        $response = $this->get(route('apps.edit', $app));

        $response
            ->assertOk()
            ->assertViewIs('app.apps.edit')
            ->assertViewHas('app');
    }

    /**
     * @test
     */
    public function it_updates_the_app(): void
    {
        $app = App::factory()->create();

        $data = [
            'title' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'type' => $this->faker->text(255),
        ];

        $response = $this->put(route('apps.update', $app), $data);

        $data['id'] = $app->id;

        $this->assertDatabaseHas('apps', $data);

        $response->assertRedirect(route('apps.edit', $app));
    }

    /**
     * @test
     */
    public function it_deletes_the_app(): void
    {
        $app = App::factory()->create();

        $response = $this->delete(route('apps.destroy', $app));

        $response->assertRedirect(route('apps.index'));

        $this->assertSoftDeleted($app);
    }
}
