<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Product;
use App\Request\ProductRequest;
use App\Resource\ProductCollection;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\PutMapping;
use Hyperf\HttpServer\Annotation\DeleteMapping;
use App\Resource\ProductResource;
use Hyperf\Swagger\Annotation\HyperfServer;
use Hyperf\Swagger\Annotation\Get;
use Hyperf\Swagger\Annotation\JsonContent;
use Hyperf\Swagger\Annotation\PathParameter;
use Hyperf\Swagger\Annotation\RequestBody;
use Hyperf\Swagger\Annotation\Response as SwaggerResponse;
use Hyperf\Swagger\Annotation\Put;
use Hyperf\Swagger\Annotation\Post;
use Hyperf\Swagger\Annotation\Delete;

#[Controller]
#[HyperfServer(name: "http")]
class ProductController
{

    #[Get(path: "/products", summary: "List all products", tags: ["Products"])]
    #[SwaggerResponse(response: 200, description: "Success", content: new JsonContent(ref: '#/components/schemas/ProductCollection'))]
    #[GetMapping(path: "")]
    public function index()
    {
        return (new ProductCollection(Product::all()))->toResponse();
    }

    #[Get(path: "/products/{id}", summary: "Show a product by ID", tags: ["Products"])]
    #[PathParameter(name: "id", description: "Product ID", required: true, schema: new \Hyperf\Swagger\Annotation\Schema(type: "integer"))]
    #[SwaggerResponse(response: 200, description: "Success", content: new JsonContent(ref: '#/components/schemas/Product'))]
    #[GetMapping(path: "{id}")]
    public function show($id)
    {
        return (new ProductResource(Product::find($id)))->toResponse();
    }
    
    #[Put(path: "/products/{id}", summary: "Update a product by ID", tags: ["Products"])]
    #[PathParameter(name: "id", description: "Product ID", required: true, schema: new \Hyperf\Swagger\Annotation\Schema(type: "integer"))]
    #[RequestBody(description: "Product data to update", required: true, content: new JsonContent(ref: '#/components/schemas/ProductRequest'))]
    #[SwaggerResponse(response: 200, description: "Success", content: new JsonContent(ref: '#/components/schemas/Product'))]
    #[PutMapping(path: "{id}")]
    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return (new ProductResource($product))->toResponse();
    }

    #[Post(path: "/products", summary: "Create a new product", tags: ["Products"])]
    #[RequestBody(description: "Product data to create", required: true, content: new JsonContent(ref: '#/components/schemas/ProductRequest'))]
    #[SwaggerResponse(response: 201, description: "Created", content: new JsonContent(ref: '#/components/schemas/Product'))]
    #[PostMapping(path: "")]
    public function create(ProductRequest $request)
    {
        $product = Product::create($request->all());
        return (new ProductResource($product))->toResponse();
    }

    #[Delete(path: "/products/{id}", summary: "Delete a product by ID", tags: ["Products"])]
    #[PathParameter(name: "id", description: "Product ID", required: true, schema: new \Hyperf\Swagger\Annotation\Schema(type: "integer"))]
    #[SwaggerResponse(response: 204, description: "No Content")]
    #[DeleteMapping(path: "{id}")]
    public function delete(ResponseInterface $response, $id)
    {
        Product::find($id)->delete();
        return $response->raw('No Content')->withStatus(204);
    }


}
