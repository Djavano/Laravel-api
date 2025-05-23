<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0",
 *     description="API para gerenciar produtos."
 * )
 *
 * @OA\Tag(
 *     name="Produtos",
 *     description="Operações com produtos"
 * )
 */

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Lista todos os produtos",
     *     tags={"Produtos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de produtos retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */

    public function index()
    {
        // retorna todos os produtos
        return Product::all();
    }
    /**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     summary="Obtém detalhes de um produto",
 *     tags={"Produtos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do produto",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Produto encontrado",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado"
 *     )
 * )
 */  
    public function show(string $id){
        $product = Product::findOrfail($id);
        return response()->json($product,200);
    }

    
   /**
 * @OA\Post(
 *     path="/api/products",
 *     summary="Cria um novo produto",
 *     tags={"Produtos"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","price","description"},
 *             @OA\Property(property="name", type="string", example="Notebook"),
 *             @OA\Property(property="price", type="number", format="float", example=3500.00),
 *             @OA\Property(property="description", type="string", example="Notebook com 8GB RAM")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Produto criado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Dados inválidos"
 *     )
 * )
 */

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);
        $product = Product::create($validatedData);
        return response()->json($product, 201);
    }


    
     
 /**
 * @OA\Put(
 *     path="/api/products/{id}",
 *     summary="Atualiza um produto existente",
 *     description="Atualiza as informações de um produto específico",
 *     tags={"Produtos"},
 *     security={{"bearerAuth": {}}},
 *     
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do produto a ser atualizado",
 *         @OA\Schema(type="integer")
 *     ),
 *     
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dados do produto para atualização",
 *         @OA\JsonContent(
 *             required={"name","price","description"},
 *             @OA\Property(property="name", type="string", example="Nome Atualizado"),
 *             @OA\Property(property="price", type="number", format="float", example=99.99),
 *             @OA\Property(property="description", type="string", example="Descrição atualizada")
 *         )
 *     ),
 *     
 *     @OA\Response(
 *         response=200,
 *         description="Produto atualizado com sucesso",
 *         @OA\JsonContent(ref="#/components/schemas/Product")
 *     ),
 *     
 *     @OA\Response(
 *         response=400,
 *         description="Requisição inválida"
 *     ),
 *     
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado"
 *     ),
 *     
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação dos dados"
 *     )
 * )
 */   
    public function update(Request $request, string $id){
        //
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|required|string'
        ]);

        $product = Product::findOrfail($id);
        $product->update($validatedData);
        return response()->json($product, 200);
    }

    
   
  /**
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     summary="Remove um produto",
 *     description="Exclui permanentemente um produto específico",
 *     tags={"Produtos"},
 *     security={{"bearerAuth": {}}},
 *     
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do produto a ser removido",
 *         @OA\Schema(type="integer")
 *     ),
 *     
 *     @OA\Response(
 *         response=204,
 *         description="Produto removido com sucesso (sem conteúdo retornado)"
 *     ),
 *     
 *     @OA\Response(
 *         response=401,
 *         description="Não autorizado"
 *     ),
 *     
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado"
 *     )
 * )
 */ 
    public function destroy(string $id)
    {
        //
        Product::findOrFail($id)->delete();
        return response(null, 204);
    }
}
