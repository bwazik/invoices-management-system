<?php

namespace App\Repositories\Roles;

use App\Interfaces\Roles\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAllRoles($request)
    {
        if ($request->ajax()) {
            $roles = Role::get();
            return datatables()->of($roles)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="box1">';
                    return $btn;
                })
                ->editColumn('name', function ($row) {
                    return $row -> name;
                })
                ->addColumn('processes', function ($row) {

                    $editBtn = '-';
                    $deleteBtn = '-';
                    if ($row -> id !== 1)
                    {
                        if(Auth::user()->can('تعديل رتبة') or Auth::user()->can('Edit Role')){
                            $editBtn = '<a href="'. route('editRole' , $row -> id) .'" class="btn btn-info btn-md"><i class="fa fa-edit"></i>
                                </a>';
                        }

                        if(Auth::user()->can('حذف رتبة') or Auth::user()->can('Delete Role')){
                            $deleteBtn = '<button type="button" class="btn btn-danger btn-md" data-toggle="modal"
                                id="deleteBtn" data-target="#deleteModal"
                                data-id="'.$row -> id.'" data-name_ar="'.$row -> name.'" data-name_en="'.$row -> name.'"
                                title="'.trans("roles/roles.delete").'"><i
                                class="fa fa-trash"></i>
                                </button>';
                        }
                    }


                    return $editBtn . ' ' . $deleteBtn;

                })

                ->rawColumns(['selectbox', 'name', 'processes'])
                ->make(true);
        }

        $permissions = Permission::get();

        return view('roles.index', compact('permissions'));
    }

    public function addRole($request)
    {
        $role = Role::create(['name' => ['en' => $request -> name_en, 'ar' => $request -> name_ar]]);

        $role->syncPermissions($request -> permission);

        return response()->json(['success' => trans('roles/roles.added')]);
    }

    public function editRole($id)
    {
        if ($id !== '1')
        {
            $role = Role::findorFail($id);
            $permissions = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();

            return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
        }
        else
        {
            abort(404);
        }
    }

    public function updateRole($request , $id)
    {
        $role = Role::findorFail($id);

        $role -> update([
            $role -> name = ['en' => $request -> name_en, 'ar' => $request -> name_ar],
        ]);

        $role->syncPermissions($request -> permission);

        return response()->json(['success' => trans('roles/roles.edited')]);
    }

    public function deleteRole($request)
    {
        Role::findOrFail($request -> id)->delete();

        return response()->json(['success' => trans('roles/roles.deleted')]);
    }

    public function deleteSelectedRoles($request)
    {
        $delete_selected_id = explode("," , $request -> delete_selected_id);

        Role::whereIn('id', $delete_selected_id)->delete();

        return response()->json(['success' => trans('roles/roles.deleted_selected')]);
    }
}
