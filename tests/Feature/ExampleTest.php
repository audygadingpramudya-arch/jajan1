<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guest users should be redirected to login.
     */
    public function test_guest_can_view_home_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Menu Restoran');
    }

    /**
     * Authenticated users can access the dashboard.
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
    }

    public function test_customer_order_appears_on_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $food = Food::query()->create([
            'name' => 'Nasi Goreng',
            'price' => 18000,
            'description' => 'Nasi goreng enak',
            'category' => 'Makanan',
            'image' => null,
        ]);

        $order = Order::query()->create([
            'customer_name' => 'Budi',
            'table_number' => '5',
            'total_price' => 18000,
            'status' => 'pending',
        ]);

        $order->items()->create([
            'food_id' => $food->id,
            'quantity' => 1,
            'subtotal' => 18000,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Budi');
        $response->assertSee('Meja 5');
    }
}
