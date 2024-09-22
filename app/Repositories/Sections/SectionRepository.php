<?php

namespace App\Repositories\Sections;

use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SectionRepository implements SectionRepositoryInterface
{
    public function getAllSections($request)
    {
        if ($request->ajax()) {
            $sections = Section::select('id', 'name', 'note', 'created_at')->get();
            return datatables()->of($sections)
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
                ->editColumn('created_at', function ($row) {
                    return $row -> created_at -> diffForHumans();
                })
                ->addColumn('processes', function ($row) {

                    $editBtn = '';
                    $deleteBtn = '';

                    if(Auth::user()->can('تعديل قسم') or Auth::user()->can('Edit Section')){
                        $editBtn = '<button type="button" class="btn btn-info btn-md" data-toggle="modal"
                            id="editBtn" data-target="#editModal"
                            data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                            data-id="'.$row -> id.'"  data-note="'.$row -> note.'"
                            title="'.trans("sections/sections.edit").'"><i
                            class="fa fa-edit"></i>
                            </button>';
                    }

                    if(Auth::user()->can('حذف قسم') or Auth::user()->can('Delete Section')){
                        $deleteBtn = '<button type="button" class="btn btn-danger btn-md" data-toggle="modal"
                            id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-name_ar="'.$row -> getTranslation('name', 'ar').'" data-name_en="'.$row -> getTranslation('name', 'en').'"
                            title="'.trans("sections/sections.delete").'"><i
                            class="fa fa-trash"></i>
                            </button>';
                    }

                    return $editBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['selectbox', 'name', 'note', 'created_at', 'processes'])
                ->make(true);
        }

        return view('sections.index');
    }

    public function addSection($request)
    {
        $section = new Section();
        $section -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar];
        $section -> note = $request -> note;

        $section->save();

        return response()->json(['success' => trans('sections/sections.added')]);
    }

    public function editSection($request)
    {
        $section = Section::findOrFail($request -> id);

        $section -> update([
            $section -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
            $section -> note = $request -> note,
        ]);

        return response()->json(['success' => trans('sections/sections.edited')]);
    }

    public function deleteSection($request)
    {
        $product = Product::where('section_id' , $request -> id)->pluck('section_id');

        if($product -> count() == 0){
            Section::findOrFail($request -> id)->delete();

            return response()->json(['success' => trans('sections/sections.deleted')]);
        }
        else
        {
            return response()->json(['error' => trans('sections/sections.if_products_found'), 400]);
        }
    }

    public function deleteSelectedSections($request)
    {
        $delete_selected_id = explode("," , $request -> delete_selected_id);

        $product = Product::whereIn('section_id' , $delete_selected_id)->pluck('section_id');

        if($product -> count() == 0){
            $delete_selected_id = explode("," , $request -> delete_selected_id);

            Section::whereIn('id', $delete_selected_id)->delete();

            return response()->json(['success' => trans('sections/sections.deleted')]);
            }
        else
        {
            return response()->json(['error' => trans('sections/sections.if_products_found_sel')]);
        }
    }
}
