<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\NotFoundException;
use App\Core\Paginator;
use App\Core\Session;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;


class SellerProductController extends Controller
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index(): void
    {
        $sellerId = (int) Session::get("user_id");
        $page = max(1, (int) ($_GET["page"] ?? 1));
        $perPage = 15;

        $result = Product::findBySeller(
            sellerId: $sellerId,
            page: $page,
            perPage: $perPage
        );

        $paginator = new Paginator(
            total: $result["total"],
            perPage: $perPage,
            currentPage: $page
        );

        $this->view("seller.products.index", [
            "title" => "My Products - KartNest",
            "products" => $result["products"],
            "paginator" => $paginator
        ]);
    }

    public function create(): void
    {
        $this->view("seller.products.create", [
            "title" => "Add Product - KartNest",
            "categories" => Category::findAll("name", "ASC"),
            "errors" => $this->getErrors()
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();

        $sellerId = (int) Session::get("user_id");
        $validator = $this->productService->validateProduct($_POST);
        
        if ($validator->fails()) {
            Session::set("errors", $validator->errors());
            Session::set("_old_input", $_POST);
            $this->redirect("/seller/products/create");
            return;
        }

        try {
            $productId = $this->productService->createProduct($_POST, $sellerId);
        } catch (\RuntimeException $e) {
            Session::flash("error", $e->getMessage());
            Session::set("_old_input", $_POST);
            $this->redirect("/seller/products/create");
            return;
        }

        Session::flash("success", "Product created successfully!");
        $this->redirect("/seller/products");
    }

    public function edit(int $id): void
    {
        $sellerId = (int) Session::get("user_id");
        $product = $this->productService->getSellerProduct(
            productId: $id,
            sellerId: $sellerId
        );

        if ($product === null) {
            throw new NotFoundException("Product not found");
        }

        $this->view("seller.products.edit", [
            "title" => "Edit Product - KartNest",
            "product" => $product,
            "categories" => Category::findAll("name", "ASC"),
            "errors" => $this->getErrors()
        ]);
    }

    public function update(int $id): void
    {
        $this->verifyCsrf();

        $sellerId = (int) Session::get("user_id");
        $validator = $this->productService->validateProduct($_POST);

        if ($validator->fails()) {
            Session::set("errors", $validator->errors());
            Session::set("_old_input", $_POST);
            $this->redirect("/seller/products/{$id}/edit");
            return;
        }

        try {
            $success = $this->productService->updateProduct(
                productId: $id,
                data: $_POST,
                sellerId: $sellerId
            );
        } catch (\RuntimeException $e) {
            Session::flash("error", $e->getMessage());
            $this->redirect("/seller/products/{$id}/edit");
            return;
        }

        if (!$success) {
            throw new NotFoundException("Product not found");
        }

        Session::flash("success", "Product updated successfully!");
        $this->redirect("/seller/products");
    }

    public function delete(int $id): void
    {
        $this->verifyCsrf();

        $sellerId = (int) Session::get("user_id");

        $success = $this->productService->deleteProduct(
            productId: $id,
            sellerId: $sellerId
        );

        if (!$success) {
            Session::flash(
                "error",
                "Product not found or you do not have permission to delete it"
            );
            $this->redirect("/seller/products");
            return;
        }

        Session::flash("success", "Product deleted successfully");
        $this->redirect("/seller/products");
    }
}