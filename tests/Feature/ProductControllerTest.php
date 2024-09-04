<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    //Testa criar um produto com sucesso  
    public function testCreateProductSuccess()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'This is a test product',
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => 'Test Product',
                     'price' => 99.99,
                     'description' => 'This is a test product',
                 ]);

        $this->assertDatabaseHas('products', $productData);
    }

    //testa falha na criação de produto devido a erro de validação
    public function testCreateProductValidationFails()
    {
        $productData = [
            'name' => '', //nome vazio
            'price' => -10, //preço inválido
            'description' => 'This is a test product',
        ];

        $response = $this->postJson('/api/products', $productData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'price']);
    }

    //Testa atualizar um produto com sucesso
    public function testUpdateProductSuccess()
    {
        $product = Product::factory()->create();

        $updatedData = [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 199.99,
            'description' => 'This is an updated test product',
        ];

        $response = $this->putJson('/api/products/' . $product->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'name' => 'Updated Product',
                     'price' => 199.99,
                     'description' => 'This is an updated test product',
                 ]);

        $this->assertDatabaseHas('products', $updatedData);
    }

    //Testa falha na atualização de produto devido a erro de validação
    public function testUpdateProductValidationFails()
    {
        $product = Product::factory()->create();

        $invalidData = [
            'id' => $product->id,
            'name' => '', //nome vazio
            'price' => -10, //preço inválido
            'description' => 'This is an updated test product',
        ];

        $response = $this->putJson('/api/products/' . $product->id, $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'price']);
    }

    //Testa falha na atualização de produto quando o produto não existe.
    public function testUpdateProductNotFound()
    {
        $response = $this->putJson('/api/products/999', [
            'id' => 999,
            'name' => 'Nonexistent Product',
            'price' => 99.99,
            'description' => 'This product does not exist',
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Product not found',
                 ]);
    }

    //Testa apagar um produto com sucesso
    public function testDeleteProductSuccess()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Product deleted successfully',
                 ]);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    //Testa falha ao apagar produto com id inválido
    public function testDeleteProductValidationFails()
    {
        $response = $this->deleteJson('/api/products/abc'); //id invalido

        $response->assertStatus(422)
                 ->assertJson([
                     'message' => 'Invalid Product ID',
                 ]);
    }

    //Testa falha ao apagar produto quando o produto não existe
    public function testDeleteProductNotFound()
    {
        $response = $this->deleteJson('/api/products/999'); // ID inexistente

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Product not found',
                 ]);
    }

    //Testa obter um produto com sucesso
    public function testGetProductSuccess()
    {
        $product = Product::factory()->create();

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $product->id,
                     'name' => $product->name,
                     'price' => $product->price,
                     'description' => $product->description,
                 ]);
    }

    //Testa falha na obtenção de produto com id invalido
    public function testGetProductValidationFails()
    {
        $response = $this->getJson('/api/products/abc'); //id invalido

        $response->assertStatus(422)
                 ->assertJson([
                     'message' => 'Invalid Product ID',
                 ]);
    }

    //Testa falha na obtenção de produto quando o produto não existe
    public function testGetProductNotFound()
    {
        $response = $this->getJson('/api/products/999'); //id inexistente

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Product not found',
                 ]);
    }
}