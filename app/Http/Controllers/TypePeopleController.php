<?php

namespace App\Http\Controllers;

use App\Models\TypePeople;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TypePeopleController extends Controller
{
    public function index(Request $request): Response
    {
        if ($request->has('direction')) $order = $request->input('direction'); else $order = 'desc';
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('sort')) $sort = $request->input('sort'); else $sort = 'id';
        if ($request->has('search')){

            $typePeople = TypePeople::where('name', 'like', '%'.$request->input('search').'%')
                ->orderBy($sort, $order)
                ->paginate($cant);
            return Inertia::render('TypePeople/List', [
                'typePeople' => $typePeople,
                'status' => session('status'),
            ]);
        }
        if ($request->has('sort')){
            $typePeople = TypePeople::orderBy($request->input('sort'), $order)->paginate($cant);
            return Inertia::render('TypePeople/List', [
                'typePeople' => $typePeople,
                'status' => session('status'),
            ]);
        }
        $typePeople = TypePeople::orderBy('id', $order)->paginate($cant);
        return Inertia::render('TypePeople/List', [
            'typePeople' => $typePeople,
            'status' => session('status'),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        TypePeople::create($request->input());
        return Redirect::route('typePeople');
    }

    public function update(Request $request, TypePeople $typePeople)
    {

        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        $typePeople->update($request->input());
    }

    public function destroy(TypePeople $typePeople)
    {
        $typePeople->delete();
    }

}
