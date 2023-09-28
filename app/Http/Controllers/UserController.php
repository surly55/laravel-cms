<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * List users
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = [];

        $query = User::query();
        if($request->has('username')) {
            $regex = '/.*' . $request->get('username') . '.*/i';
            $query->where('username', 'regexp', $regex);
            $search['username'] = $request->get('username');
        }
        if($request->has('email')) {
            $regex = '/.*' . $request->get('email') . '.*/i';
            $query->where('email', 'regexp', $regex);
            $search['email'] = $request->get('email');
        }

        $sortRule = 'username';
        $sortOrder = 'asc';
        if($request->has('sort')) {
            $sortRule = $request->get('sort');
        }
        if($request->has('order')) {
            $sortOrder = $request->get('order');
        }

        $users = $query->orderBy($sortRule, $sortOrder)->paginate(10);

        return view('user.index', [
            'title' => 'Users',
            'users' => $users,
            'search' => $search,
            'sortRule' => $sortRule,
            'sortOrder' => $sortOrder === 'asc' ? 'desc' : 'asc',
            'bodyClasses' => 'model-index user-index',
        ]);
    }

    /**
     * Show details for a User with given ID
     * 
     * @param string $id User ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.show', [
            'title' => 'View user: ' . $user->username,
            'user' => $user,
            'bodyClasses' => 'model-show user-show',
        ]);
    }

    /**
     * Form for creating new users
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.create', [
            'title' => 'Create user',
            'bodyClasses' => 'model-create user-create',
        ]);
    }

    /**
     * Create new User and store it
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());

        return redirect()->route('user.index');
    }

    /**
     * Edit existing user
     * 
     * @param string $id User ID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', [
            'user' => $user,
            'bodyClasses' => 'model-edit user-edit',
        ]);
    }

    /**
     * Store updated User
     */
    public function update($id, UserRequest $request)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect()->route('user.index');
    }

    /**
     * Delete User
     */
    public function destroy($id, Request $request) 
    {
        try {
            User::destroy($id);
            if($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User successfully deleted.',
                ], 200);
            }
        } catch(ModelNotFoundException $e) {
            if($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete user.',
                ], 500);
            }
            return redirect()->route('user.index');
        }

        return redirect()->route('user.index');
    }
}