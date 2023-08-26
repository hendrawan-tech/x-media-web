<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Invoice;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceControllerTest extends TestCase
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
    public function it_displays_index_view_with_invoices(): void
    {
        $invoices = Invoice::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('invoices.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.invoices.index')
            ->assertViewHas('invoices');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_invoice(): void
    {
        $response = $this->get(route('invoices.create'));

        $response->assertOk()->assertViewIs('app.invoices.create');
    }

    /**
     * @test
     */
    public function it_stores_the_invoice(): void
    {
        $data = Invoice::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('invoices.store'), $data);

        $this->assertDatabaseHas('invoices', $data);

        $invoice = Invoice::latest('id')->first();

        $response->assertRedirect(route('invoices.edit', $invoice));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.show', $invoice));

        $response
            ->assertOk()
            ->assertViewIs('app.invoices.show')
            ->assertViewHas('invoice');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.edit', $invoice));

        $response
            ->assertOk()
            ->assertViewIs('app.invoices.edit')
            ->assertViewHas('invoice');
    }

    /**
     * @test
     */
    public function it_updates_the_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $user = User::factory()->create();

        $data = [
            'external_id' => $this->faker->text(255),
            'invoice_url' => $this->faker->text(255),
            'price' => $this->faker->text(255),
            'status' => $this->faker->word(),
            'user_id' => $user->id,
        ];

        $response = $this->put(route('invoices.update', $invoice), $data);

        $data['id'] = $invoice->id;

        $this->assertDatabaseHas('invoices', $data);

        $response->assertRedirect(route('invoices.edit', $invoice));
    }

    /**
     * @test
     */
    public function it_deletes_the_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete(route('invoices.destroy', $invoice));

        $response->assertRedirect(route('invoices.index'));

        $this->assertSoftDeleted($invoice);
    }
}
