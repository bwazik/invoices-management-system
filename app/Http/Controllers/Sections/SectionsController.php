<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Sections\SectionsRequest;
use App\Interfaces\Sections\SectionRepositoryInterface;

class SectionsController extends Controller
{
    protected $section;

    public function __construct(SectionRepositoryInterface $section)
    {
        $this -> section = $section;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Sections List', ['only' => ['index']]);
            $this->middleware('permission:Add Section', ['only' => ['add']]);
            $this->middleware('permission:Edit Section', ['only' => ['edit']]);
            $this->middleware('permission:Delete Section', ['only' => ['delete']]);
            $this->middleware('permission:Delete Selected Sections', ['only' => ['deleteSelected']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:الأقسام', ['only' => ['index']]);
            $this->middleware('permission:إضافة قسم', ['only' => ['add']]);
            $this->middleware('permission:تعديل قسم', ['only' => ['edit']]);
            $this->middleware('permission:حذف قسم', ['only' => ['delete']]);
            $this->middleware('permission:حذف الأقسام المختارة', ['only' => ['deleteSelected']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> section -> getAllSections($request);
    }

    public function add(SectionsRequest $request)
    {
        return $this -> section -> addSection($request);
    }

    public function edit(SectionsRequest $request)
    {
        return $this -> section -> editSection($request);
    }

    public function delete(Request $request)
    {
        return $this -> section -> deleteSection($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> section -> deleteSelectedSections($request);
    }
}
