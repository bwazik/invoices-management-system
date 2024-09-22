<?php

namespace App\Interfaces\Products;

interface ProductRepositoryInterface
{
    #1 Get All Products
    public function getAllProducts($request);

    #2 Add Product
    public function addProduct($request);

    #3 Edit Product
    public function editProduct($request);

    #4 Delete Product
    public function deleteProduct($request);

    #5 Delete Selected Products
    public function deleteSelectedProducts($request);
}
