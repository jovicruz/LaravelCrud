<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){
        return Product::all(); 
    }

    public function createProduct(Request $data){
        try {
            //Valida os dados
            $validatedData = $data->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);
    
            //Cria o produto
            $product = Product::create($validatedData);
            return response($product, 201);

        } catch (ValidationException $e) {
            //Trata de erros de validação
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function updateProduct(Request $data){
        try {
            $validatedData = $data->validate([
                'id' => 'required|numeric',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
            ]);
    
            //Atualiza o produto
            $product = Product::findOrFail($validatedData['id']);
            $product->update($validatedData);
            return response($product, 200);

        } catch (ValidationException $e) {
            //Trata erros de validação
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            //Trata caso o produto não seja encontrado
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
        
    }

    public function deleteProduct($id){
        try {
            //Valida ID
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'message' => 'Invalid Product ID',
                ], 422);
            }
    
            //Procura e apaga o produto
            $product = Product::findOrFail($id);
            $product->delete();
    
            return response(['message' => 'Product deleted successfully'], 200);

        } catch (ValidationException $e) {
            //Trata erros de validação
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);

        } catch (ModelNotFoundException $e) {
            //Trata caso o produto não seja encontrado
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function getProduct($id){
        try {
            // Valida ID
            if (!is_numeric($id) || $id <= 0) {
                return response()->json([
                    'message' => 'Invalid Product ID',
                ], 422); // Retorna 422 (Unprocessable Entity)
            }
    
            //Procura o produto
            $product = Product::findOrFail($id);
    
            return response($product, 200);
        } catch (ValidationException $e) {
            //Trata erros de validação
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            //Trata caso o produto não seja encontrado
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
    }
}
