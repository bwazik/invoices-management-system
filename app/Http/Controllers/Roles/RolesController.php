<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Roles\RolesRequest;
use App\Interfaces\Roles\RoleRepositoryInterface;

class RolesController extends Controller
{
    protected $role;

    public function __construct(RoleRepositoryInterface $role)
    {
        $this -> role = $role;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Users Permissions', ['only' => ['index']]);
            $this->middleware('permission:Add Role', ['only' => ['add']]);
            $this->middleware('permission:Edit Role', ['only' => ['edit', 'update']]);
            $this->middleware('permission:Delete Role', ['only' => ['delete']]);
            $this->middleware('permission:Delete Selected Roles', ['only' => ['deleteSelected']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:صلاحيات المستخدمين', ['only' => ['index']]);
            $this->middleware('permission:اضافة رتبة', ['only' => ['add']]);
            $this->middleware('permission:تعديل رتبة', ['only' => ['edit', 'update']]);
            $this->middleware('permission:حذف رتبة', ['only' => ['delete']]);
            $this->middleware('permission:حذف الرتب المختارة', ['only' => ['deleteSelected']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> role -> getAllRoles($request);
    }

    public function add(RolesRequest $request)
    {
        return $this -> role -> addRole($request);
    }

    public function edit($id)
    {
        return $this -> role -> editRole($id);
    }

    public function update(RolesRequest $request, $id)
    {
        return $this -> role -> updateRole($request, $id);
    }

    public function delete(Request $request)
    {
        return $this -> role -> deleteRole($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> role -> deleteSelectedRoles($request);
    }
}
