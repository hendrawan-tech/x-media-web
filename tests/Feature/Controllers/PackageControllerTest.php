<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Package;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageControllerTest extends TestCase
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
    public function it_displays_index_view_with_packages(): void
    {
        $packages = Package::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('packages.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.packages.index')
            ->assertViewHas('packages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_package(): void
    {
        $response = $this->get(route('packages.create'));

        $response->assertOk()->assertViewIs('app.packages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_package(): void
    {
        $data = Package::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('packages.store'), $data);

        $this->assertDatabaseHas('packages', $data);

        $package = Package::latest('id')->first();

        $response->assertRedirect(route('packages.edit', $package));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_package(): void
    {
        $package = Package::factory()->create();

        $response = $this->get(route('packages.show', $package));

        $response
            ->assertOk()
            ->assertViewIs('app.packages.show')
            ->assertViewHas('package');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_package(): void
    {
        $package = Package::factory()->create();

        $response = $this->get(route('packages.edit', $package));

        $response
            ->assertOk()
            ->assertViewIs('app.packages.edit')
            ->assertViewHas('package');
    }

    /**
     * @test
     */
    public function it_updates_the_package(): void
    {
        $package = Package::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'price' => $this->faker->text(255),
            'month' => $this->faker->text(255),
            'speed' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('packages.update', $package), $data);

        $data['id'] = $package->id;

        $this->assertDatabaseHas('packages', $data);

        $response->assertRedirect(route('packages.edit', $package));
    }

    /**
     * @test
     */
    public function it_deletes_the_package(): void
    {
        $package = Package::factory()->create();

        $response = $this->delete(route('packages.destroy', $package));

        $response->assertRedirect(route('packages.index'));

        $this->assertSoftDeleted($package);
    }
}
