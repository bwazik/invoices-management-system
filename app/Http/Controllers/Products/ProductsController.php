<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Products\ProductsRequest;
use App\Interfaces\Products\ProductRepositoryInterface;

class ProductsController extends Controller
{
    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        $this -> product = $product;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Products List', ['only' => ['index']]);
            $this->middleware('permission:Add Product', ['only' => ['add']]);
            $this->middleware('permission:Edit Product', ['only' => ['edit']]);
            $this->middleware('permission:Delete Product', ['only' => ['delete']]);
            $this->middleware('permission:Delete Selected Products', ['only' => ['deleteSelected']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:المنتجات', ['only' => ['index']]);
            $this->middleware('permission:إضافة منتج', ['only' => ['add']]);
            $this->middleware('permission:تعديل منتج', ['only' => ['edit']]);
            $this->middleware('permission:حذف منتج', ['only' => ['delete']]);
            $this->middleware('permission:حذف المنتجات المختارة', ['only' => ['deleteSelected']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> product -> getAllProducts($request);
    }

    public function add(ProductsRequest $request)
    {
        return $this -> product -> addProduct($request);
    }

    public function edit(ProductsRequest $request)
    {
        return $this -> product -> editProduct($request);
    }

    public function delete(Request $request)
    {
        return $this -> product -> deleteProduct($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> product -> deleteSelectedProducts($request);
    }
}
