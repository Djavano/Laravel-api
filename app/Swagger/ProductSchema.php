<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Produto",
 *     description="Modelo de um produto",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Notebook"),
 *     @OA\Property(property="description", type="string", example="Descrição do produto"),
 *     @OA\Property(property="price", type="string", format="decimal", example=2999.99),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 12:00:00")
 * )
 */
class ProductSchema {}