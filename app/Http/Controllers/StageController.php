<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\Process;
use App\Models\Stage;
use App\Models\TypePeople;
use App\Models\TypeStage;
use App\Models\PeopleStage;
use App\Models\File;
use Cloudinary\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StageController extends Controller
{
    public function show(Stage $stage)
    {
        $stage->load('typeStage', 'process', 'people.typePeople', 'people', 'files');
        return Inertia::render('Stage/Show', [
            'stage' => $stage
        ]);
    }

    public function create(Process $process): Response
    {
        return Inertia::render('Stage/Create', [
            'process' => $process,
            'types_people' => TypePeople::all(),
            'types' => TypeStage::all(),
            'people' => People::all()
        ]);
        
    }
    public function store(Request $request)
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

        $groupPeople = $request->people; 
        if($groupPeople != null){
            foreach ($groupPeople as $people) {
                if ($people['id'] == null) {
                    $people = People::create($people);
                } else {
                    $peopleupdate = People::find($people['id']);
                    $peopleupdate->update($people);
                }

                $peopleStage = new PeopleStage();
                $peopleStage->people_id = $people['id'];
                $peopleStage->stage_id = $stage->id;
                $peopleStage->save();
            }
        }

        $groupFiles = $request->input('files');
        if($groupFiles != null){
            foreach ($groupFiles as $file) {
               File::create([
                     'name' => $file['original_filename'],
                     'url' => $file['url'],
                     'stage_id' => $stage->id
               ]);
            }
        }
        return redirect()->route('stages.show', $stage->id);

    }

    public function edit(Stage $stage): Response
    {
        $stage->load('typeStage', 'process', 'people.typePeople', 'people', 'files');
        return Inertia::render('Stage/Edit', [
            'stage' => $stage,
            'types_people' => TypePeople::all(),
            'types' => TypeStage::all(),
            'people' => People::all()
        ]);
    }

    public function update(Request $request, Stage $stage)
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

        $groupPeople = $request->people;

        $peopleStage = PeopleStage::where('stage_id', $stage->id)->get();
        foreach ($peopleStage as $people) {
            $people->delete();
        }

        foreach ($groupPeople as $people) {
            if ($people['id'] == null) {
                $people = People::create($people);
            } else {
                $peopleUpdate = People::find($people['id']);
                $peopleUpdate->update($people);
            }

            $peopleStage = new PeopleStage();
            $peopleStage->people_id = $people['id'];
            $peopleStage->stage_id = $stage->id;
            $peopleStage->save();
        }

        $groupFiles = $request->input('files');
        $filesStage = File::where('stage_id', $stage->id)->get();
        foreach ($filesStage as $file) {
            $file->delete();
        }
        if($groupFiles != null){
            foreach ($groupFiles as $file) {
               File::create([
                     'name' => $file['original_filename'],
                     'url' => $file['url'],
                     'stage_id' => $stage->id
               ]);
            }
        }
            
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

    public function validatePeople(Request $request): void
    {
        
        $request->validate([
            'name' => 'required|max:100|min:3|string',
            'email' => 'required|max:100|min:3|email|unique:people,email,'.$request->id,
            'phone' => 'nullable|max:100|min:3|string',
            'address' => 'nullable|max:100|min:3|string',
            'nit' => 'required|max:100|min:3|string|unique:people,nit,'.$request->id,
            'issue_nit' => 'nullable|max:100|min:3|string',
            'num_ministry' => 'nullable|max:100|min:3|string',
            'num_dispach' => 'nullable|max:100|min:3|string',
            'radicated' => 'nullable|max:100|min:3|string',
            'authority' => 'nullable|max:100|min:3|string',
            'number' => 'nullable|max:100|min:3|string',
            'type_people_id' => 'required|integer',
        ]);
    }

}
