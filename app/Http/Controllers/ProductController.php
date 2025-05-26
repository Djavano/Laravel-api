<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
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
        return ProductResource::collection(Product::all());
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

        return new ProductResource($product);
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

    public function store(StoreProductRequest $request){
        $validData = $request->validated();
        $product = Product::create($validData);
        return (new ProductResource($product))->response()->setStatusCode(201);
    }


    
     
/**
 * @OA\Put(
 *     path="/api/products/{id}",
 *     summary="Atualiza um produto existente",
 *     tags={"Produtos"},
 *     description="Atualiza parcial ou totalmente um produto. Pelo menos um dos campos (name, price ou description) deve ser fornecido.",
 *     operationId="updateProduct",
 *     security={{"bearerAuth": {}}},
 *     
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do produto a ser atualizado",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *             example=1
 *         )
 *     ),
 *     
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dados do produto para atualização (pelo menos um campo obrigatório)",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="name",
 *                 type="string",
 *                 maxLength=255,
 *                 example="Notebook Premium",
 *                 description="Nome do produto"
 *             ),
 *             @OA\Property(
 *                 property="price",
 *                 type="number",
 *                 format="float",
 *                 minimum=0,
 *                 example=4599.99,
 *                 description="Preço do produto (deve ser maior ou igual a 0)"
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 example="Notebook com 16GB RAM e SSD 512GB",
 *                 description="Descrição detalhada do produto"
 *             )
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
 *         description="Requisição inválida",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Requisição inválida")
 *         )
 *     ),
 *     
 *     @OA\Response(
 *         response=401,
 *         description="Não autorizado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Não autenticado")
 *         )
 *     ),
 *     
 *     @OA\Response(
 *         response=404,
 *         description="Produto não encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Produto não encontrado")
 *         )
 *     ),
 *     
 *     @OA\Response(
 *         response=422,
 *         description="Erro de validação",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Os dados fornecidos são inválidos."
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="array",
 *                     @OA\Items(type="string", example="O campo nome é obrigatório quando nenhum dos outros campos está presente.")
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="array",
 *                     @OA\Items(type="string", example="O campo preço deve ser um número.")
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     type="array",
 *                     @OA\Items(type="string", example="O campo descrição deve ser uma string.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */  
    public function update(UpdateProductRequest $request, string $id){
        //
        $product = Product::findOrfail($id);
        $validatedData = $request->validated();
        $product->update($validatedData);

        return new ProductResource($product);
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
        return response()->json(null, 204);
    }
}
