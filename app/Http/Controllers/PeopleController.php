<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\TypePeople;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PeopleController extends Controller
{
    public function index(Request $request): Response
    {
        $types = TypePeople::all();
        if ($request->has('direction')) $order = $request->input('direction'); else $order = 'desc';
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('sort')) $sort = $request->input('sort'); else $sort = 'id';
        if ($request->has('search')){
            $people = People::where('name', 'like', '%'.$request->input('search').'%')
                ->orWhere('email', 'like', '%'.$request->input('search').'%')
                ->orWhere('nit', 'like', '%'.$request->input('search').'%')
                ->orWhere('num_ministry', 'like', '%'.$request->input('search').'%')
                ->orWhere('num_dispach', 'like', '%'.$request->input('search').'%')
                ->orWhere('radicated', 'like', '%'.$request->input('search').'%')
                ->orWhere('authority', 'like', '%'.$request->input('search').'%')
                ->orWhere('number', 'like', '%'.$request->input('search').'%')
                ->orderBy($sort, $order)
                ->paginate($cant);

            $people->load('typePeople');
            return Inertia::render('People/List', [
                'people' => $people,
                'types' => $types,
            ]);
        }
        if ($request->has('sort')){
            $people = People::orderBy($request->input('sort'), $order)->paginate($cant);
            $people->load('typePeople');
            return Inertia::render('People/List', [
                'people' => $people,
                'types' => $types,
            ]);
        }
        $people = People::orderBy('id', $order)->paginate($cant);
        $people->load('typePeople');
        return Inertia::render('People/List', [
            'people' => $people,
            'types' => $types,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|min:3|string',
            'email' => 'required|max:100|min:3|email',
            'phone' => 'nullable|max:100|min:3|string',
            'address' => 'nullable|max:100|min:3|string',
            'nit' => 'required|max:100|min:3|string',
            'issue_nit' => 'nullable|max:100|min:3|string',
            'num_ministry' => 'nullable|max:100|min:3|string',
            'num_dispach' => 'nullable|max:100|min:3|string',
            'radicated' => 'nullable|max:100|min:3|string',
            'authority' => 'nullable|max:100|min:3|string',
            'number' => 'nullable|max:100|min:3|string',
            'type_people_id' => 'required|integer',
        ]);
        People::create($request->all());
    }

    public function update(Request $request, People $people)
    {
        $request->validate([
            'name' => 'required|max:100|min:3|string',
            'email' => 'required|max:100|min:3|email',
            'phone' => 'nullable|max:100|min:3|string',
            'address' => 'nullable|max:100|min:3|string',
            'nit' => 'required|max:100|min:3|string',
            'issue_nit' => 'nullable|max:100|min:3|string',
            'num_ministry' => 'nullable|max:100|min:3|string',
            'num_dispach' => 'nullable|max:100|min:3|string',
            'radicated' => 'nullable|max:100|min:3|string',
            'authority' => 'nullable|max:100|min:3|string',
            'number' => 'nullable|max:100|min:3|string',
            'type_people_id' => 'required|integer',
        ]);
        $people->update($request->all());
    }

    public function destroy(People $People)
    {
        $People->delete();
    }
}
