<?php

namespace App\Repositories\Products;

use App\Interfaces\Products\ProductRepositoryInterface;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts($request)
    {
        if ($request->ajax()) {
            $products = Product::select('id', 'name', 'note', 'section_id', 'created_at')->get();
            return datatables()->of($products)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="box1">';
                    return $btn;
                })
                ->addColumn('name', function ($row) {
                    return $row -> name;
                })
                ->editColumn('note', function ($row) {
                    return $row -> note == null ? '-' : $row -> note;
                })
                ->addColumn('section', function ($row) {
                    return $row -> section -> name;
                })
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
                })
                ->addColumn('processes', function ($row) {

                    $editBtn = '';
                    $deleteBtn = '';

                    if(Auth::user()->can('تعديل منتج') or Auth::user()->can('Edit Product')){
                        $editBtn = '<button type="button" class="btn btn-info btn-md" data-toggle="modal"
                                id="editBtn" data-target="#editModal"
                                data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                data-id="'.$row -> id.'"  data-note="'.$row -> note.'" data-section="'.$row -> section -> id.'"
                                title="'.trans("Products/Products.edit").'"><i
                                class="fa fa-edit"></i>
                                </button>';
                    }

                    if(Auth::user()->can('حذف منتج') or Auth::user()->can('Delete Product')){
                        $deleteBtn = '<button type="button" class="btn btn-danger btn-md" data-toggle="modal"
                                id="deleteBtn" data-target="#deleteModal"
                                data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                                title="'.trans("Products/Products.delete").'"><i
                                class="fa fa-trash"></i>
                                </button>';
                    }

                    return $editBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['selectbox', 'name', 'note', 'section', 'created_at', 'processes'])
                ->make(true);
        }

        $sections = Section::select('id', 'name')->get();

        return view('products.index', compact('sections'));
    }

    public function addProduct($request)
    {
        $product = new Product();
        $product -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar];
        $product -> note = $request -> note;
        $product -> section_id = $request -> section;

        $product->save();

        return response()->json(['success' => trans('products/products.added')]);
    }

    public function editProduct($request)
    {
        $product = Product::findOrFail($request -> id);

        $product -> update([
            $product -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
            $product -> note = $request -> note,
            $product -> section_id = $request -> section,
        ]);

        return response()->json(['success' => trans('products/products.edited')]);
    }

    public function deleteProduct($request)
    {
        Product::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('products/products.deleted')]);
    }

    public function deleteSelectedProducts($request)
    {
        $delete_selected_id = explode("," , $request -> delete_selected_id);

        Product::whereIn('id', $delete_selected_id)->delete();

        return response()->json(['success' => trans('products/products.deleted')]);
    }
}
