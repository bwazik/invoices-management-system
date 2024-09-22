<?php

namespace App\Repositories\Users;

use App\Interfaces\Users\UserRepositoryInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers($request)
    {
        if ($request->ajax()) {
            $users = User::select('id', 'name', 'email', 'password', 'status', 'roles_name', 'status')->get();

            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('selectbox', function ($row) {
                    $btn = '<input type="checkbox" value="'. $row -> id .'" class="box1">';
                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    if ($row -> status == 0){
                        return '<i class="pe-2 fa fa-circle text-danger"></i>';
                    }
                    elseif($row -> status == 1){
                        return '<i class="pe-2 fa fa-circle text-success"></i>';
                    }
                    else{
                        return 'error';
                    }
                })
                ->addColumn('roles_name', function ($row) {
                    return $row -> roles_name;
                })
                ->addColumn('processes', function ($row) {

                    $editBtn = '';
                    $deleteBtn = '';

                    if(Auth::user()->can('تعديل مستخدم') or Auth::user()->can('Edit User')){
                        $editBtn = '<a href="'. route('editUser' , $row -> id) .'" class="btn btn-info btn-md"><i class="fa fa-edit"></i>
                            </a>';
                    }

                    if(Auth::user()->can('حذف مستخدم') or Auth::user()->can('Delete User')){
                        $deleteBtn = '<button type="button" class="btn btn-danger btn-md" data-toggle="modal"
                            id="deleteBtn" data-target="#deleteModal"
                            data-id="'.$row -> id.'" data-name="'.$row -> name.'" data-email="'.$row -> email.'">
                            <i class="fa fa-trash"></i>
                            </button>';
                    }

                    return $editBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['selectbox', 'status', 'roles_name', 'processes'])
                ->make(true);
        }

        $roles = Role::get();

        return view('users.index', compact('roles'));
    }

    public function addUser($request)
    {
        $user = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'roles_name' => $request -> role,
            'status' => $request -> status,
        ]);

        // $locale = app()->getLocale();

        $role = Role::whereIn('name->en' , $request -> role)->get();

        $user->assignRole([$role]);

        return response()->json(['success' => trans('users/users.added')]);
    }

    public function editUser($id)
    {
        $user = User::findorFail($id);
        $roles = Role::get();
        $userRole = $user -> roles -> pluck('id' , 'id')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function UpdateUser($request)
    {
        $input = $request->all();

        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        else
        {
            $input = Arr::except($input,array('password'));
        }

        $user = User::findOrFail($request -> id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id' , $request -> id)->delete();

        $role = Role::whereIn('name->en' , $request -> roles_name)->get();
        $user->assignRole([$role]);

        return response()->json(['success' => trans('users/users.edited')]);
    }

    public function deleteUser($request)
    {
        User::findOrFail($request -> id)->delete();
        DB::table('model_has_roles')->where('model_id' , $request -> id)->delete();

        return response()->json(['success' => trans('users/users.deleted')]);
    }

    public function deleteSelectedUsers($request)
    {
        $delete_selected_id = explode("," , $request -> delete_selected_id);

        User::whereIn('id', $delete_selected_id)->delete();
        DB::table('model_has_roles')->whereIn('model_id' , $delete_selected_id)->delete();

        return response()->json(['success' => trans('users/users.deleted_selected')]);
    }
}
