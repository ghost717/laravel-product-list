<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_products_index()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_can_create_new_product()
    {   
        $productData = [
            'name' => 'Test Product',
            'description' => 'This is a test product',
        ];

        $product = Product::create($productData);
    
        Price::create([
            'product_id' => $product->id,
            'price' => 10.99,
        ]);
        
        $response = $this->post('/products', $productData);
        $response->assertStatus(302);
        //Executing & Asserting
        $this->assertTrue($product->prices()->exists());
    }

    public function test_can_update_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $newData = [
            'name' => 'Updated Product',
            'description' => 'This is an updated test product',
        ];

        $response = $this->put("/products/{$product->id}", $newData);

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', $newData);
    }

    public function test_can_delete_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->delete("/products/{$product->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
