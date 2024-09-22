<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Users\UserRepositoryInterface;
use App\Http\Requests\Users\UsersRequest;
use App\Http\Requests\Users\EditUserRequest;

class UsersController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this -> user = $user;

        if(app()->getLocale() == 'en')
        {
            $this->middleware('permission:Users List', ['only' => ['index']]);
            $this->middleware('permission:Add User', ['only' => ['add']]);
            $this->middleware('permission:Edit User', ['only' => ['edit', 'update']]);
            $this->middleware('permission:Delete User', ['only' => ['delete']]);
            $this->middleware('permission:Delete Selected Users', ['only' => ['deleteSelected']]);
        }
        elseif(app()->getLocale() == 'ar')
        {
            $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);
            $this->middleware('permission:اضافة مستخدم', ['only' => ['add']]);
            $this->middleware('permission:تعديل مستخدم', ['only' => ['edit', 'update']]);
            $this->middleware('permission:حذف مستخدم', ['only' => ['delete']]);
            $this->middleware('permission:حذف المستخدمين المختارين', ['only' => ['deleteSelected']]);
        }
    }

    public function index(Request $request)
    {
        return $this -> user -> getAllUsers($request);
    }

    public function add(UsersRequest $request)
    {
        return $this -> user -> addUser($request);
    }

    public function edit($id)
    {
        return $this -> user -> editUser($id);
    }

    public function update(EditUserRequest $request)
    {
        return $this -> user -> updateUser($request);
    }

    public function delete(Request $request)
    {
        return $this -> user -> deleteUser($request);
    }

    public function deleteSelected(Request $request)
    {
        return $this -> user -> deleteSelectedUsers($request);
    }
}
