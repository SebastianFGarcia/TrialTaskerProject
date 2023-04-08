<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\Stage;
use App\Models\TypeStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    public function show(Stage $stage): Response
    {
        return Inertia::render('Stage/Show', [
            'stage' => $stage
        ]);
    }

    public function create(Process $process): Response
    {

        return Inertia::render('Stage/Create', [
            'process' => $process,
            'types' => TypeStage::all()
        ]);
        
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'type_stage_id' => 'required',
            'procedure_date' => 'required|date',
            'description' => 'required',
        ]);

        $stage = new Stage();
        $stage->name = $request->name;
        $stage->procedure_date = $request->procedure_date;
        $stage->description = $request->description;
        $stage->type_stage_id = $request->type_stage_id;
        $stage->process_id = $request->process_id;
        $stage->save();

        return redirect()->route('processes.show', $request->process_id);
    }

    public function edit(Stage $stage): Response
    {
        return Inertia::render('Stage/Edit', [
            'stage' => $stage,
            'types' => TypeStage::all()
        ]);
    }

    public function update(Request $request, Stage $stage): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'type_stage_id' => 'required',
            'procedure_date' => 'required|date',
            'description' => 'required',
        ]);

        $stage->name = $request->name;
        $stage->procedure_date = $request->procedure_date;
        $stage->description = $request->description;
        $stage->type_stage_id = $request->type_stage_id;
        $stage->save();

        return redirect()->route('stages.show', $stage->id);
    }
    public function changeStatus(Stage $stage): RedirectResponse
    {
        $stage->status = !$stage->status;
        $stage->save();
        return redirect()->route('processes.show', $stage->process_id);
    }

    public function destroy(Stage $stage): RedirectResponse
    {
        $stage->delete();
        return redirect()->route('processes.show', $stage->process_id);
    }
}
