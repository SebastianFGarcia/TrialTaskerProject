<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    
    public function index(Request $request):Response
    {
        if ($request->has('direction')) $order = $request->input('direction'); else $order = 'asc';
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('search')){
            $users = User::where('name', 'like', '%'.$request->input('search').'%')
                ->orWhere('email', 'like', '%'.$request->input('search').'%')
                ->orderBy('id', $order)
                ->paginate($cant);
            return Inertia::render('User/List', [
                'users' => $users,
            ]);
        }
        if ($request->has('sort')){
            $users = User::orderBy($request->input('sort'), $order)->paginate($cant);
            return Inertia::render('User/List', [
                'users' => $users,
            ]);
        }
        $users = User::orderBy('id', $order)->paginate($cant);
        return Inertia::render('User/List', [
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): void
    {
        $user->update(['is_active' => $user->is_active == 1 ? 0 : 1]);
    }

}
