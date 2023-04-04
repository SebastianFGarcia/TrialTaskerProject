<?php

namespace App\Http\Controllers;

use App\Models\TypeStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TypeStageController extends Controller
{
    public function index(Request $request): Response
    {
        if ($request->has('direction')) $order = $request->input('direction'); else $order = 'desc';
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('sort')) $sort = $request->input('sort'); else $sort = 'id';
        if ($request->has('search')){

            $typeStage = TypeStage::where('name', 'like', '%'.$request->input('search').'%')
                ->orderBy($sort, $order)
                ->paginate($cant);
            return Inertia::render('TypeStage/List', [
                'typeStage' => $typeStage,
                'status' => session('status'),
            ]);
        }
        if ($request->has('sort')){
            $typeStage = TypeStage::orderBy($request->input('sort'), $order)->paginate($cant);
            return Inertia::render('TypeStage/List', [
                'typeStage' => $typeStage,
                'status' => session('status'),
            ]);
        }
        $typeStage = TypeStage::orderBy('id', $order)->paginate($cant);
        return Inertia::render('TypeStage/List', [
            'typeStage' => $typeStage,
            'status' => session('status'),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        TypeStage::create($request->input());
        return Redirect::route('typeStage');
    }

    public function update(Request $request, TypeStage $typeStage)
    {

        $request->validate([
            'name' => 'required|string|max:100'
        ]);
        $typeStage->update($request->input());
    }

    public function destroy(TypeStage $typeStage)
    {
        $typeStage->delete();
    }
}
