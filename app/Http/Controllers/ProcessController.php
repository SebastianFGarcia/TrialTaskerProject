<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\People;
use App\Models\Stage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use SebastianBergmann\Type\TrueType;

class ProcessController extends Controller
{
    public function index(Request $request): Response
    {
        
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('search')){
            /* la cosulta trae la busqueda de el nombre, radicado y personas con el nombre y tosas las consultas deben estar con el usuario autenticado */
            $processes = Process::where('user_id', auth()->user()->id)
                ->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('radicate', 'like', '%' . $request->input('search') . '%')
                        ->orWhereHas('people', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('search') . '%');
                        });
                })
                ->orderBy('updated_at', 'desc')
                ->paginate($cant);
            $processes->load('people');
            return Inertia::render('Process/List', [
                'processes' => $processes,
            ]);
        }
        $processes = Process::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->paginate($cant);
        $processes->load('people');
        return Inertia::render('Process/List', [
            'processes' => $processes,
        ]);
    } 

    public function show(Request $request, Process $process)
    {
        $process->load('people');
        if ($request->has('per_page')) $cant = $request->input('per_page'); else $cant = 10;
        if ($request->has('search')){
            /* la cosulta trae la busqueda de el nombre, radicado y personas con el nombre y tosas las consultas deben estar con el usuario autenticado */
            $stages = Stage::where('process_id', $process->id)
                ->where('name', 'like', '%' . $request->input('search') . '%')
                ->orderBy('id', 'desc')
                ->paginate($cant);
            $stages->load('process', 'typeStage');
            return Inertia::render('Process/Show', [
                'process' => $process,
                'stages' => $stages,
            ]);
        }
        $stages = Stage::where('process_id',  $process->id)
            ->orderBy('id', 'desc')
            ->paginate($cant);
        $stages->load('process', 'typeStage');
        return Inertia::render('Process/Show', [
            'process' => $process,
            'stages' => $stages,
        ]);
    }

    public function create(): Response
    {
        $people = People::all();
        return Inertia::render('Process/Create', [
            'people' => $people,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [];
        if(!$request->input('people_name')){
            $rules = [
                'name' => 'required|string|max:255|min:3',
                'radicate' => 'required|string|max:255|min:3',
                'description' => 'required|string|min:3',
                'people_id' => 'required|integer|exists:people,id',
            ];
        }else {

            $rules = [
                'name' => 'required|string|max:255|min:3',
                'radicate' => 'required|string|max:255|min:3',
                'description' => 'required|string|min:3',
                'people_name' => 'required|string|max:255|min:3',
                'people_nit' => 'required|string|max:255|min:5|unique:people,nit'.($request->input('people_id') ? ','.$request->input('people_id') : ''),
                'people_email' => 'required|email|max:255|min:5',
                'people_phone' => 'required|string|max:255|min:6',
                'people_address' => 'required|string|max:255|min:5',
            ];
        }
        $messages = [
            'people_id.required' => 'El cliente es requerido',
            'people_id.integer' => 'El cliente debe ser un numero',
            'people_id.exists' => 'El cliente no existe',
            'people_name.required' => 'El nombre del cliente es requerido',
            'people_name.string' => 'El nombre del cliente debe ser un texto',
            'people_name.max' => 'El nombre del cliente debe tener maximo 255 caracteres',
            'people_name.min' => 'El nombre del cliente debe tener minimo 3 caracteres',
            'people_nit.required' => 'El documento del cliente es requerido',
            'people_nit.string' => 'El documento del cliente debe ser un texto',
            'people_nit.max' => 'El documento del cliente debe tener maximo 255 caracteres',
            'people_nit.min' => 'El documento del cliente debe tener minimo 5 caracteres',
            'people_nit.unique' => 'El documento del cliente ya existe',
            'people_email.required' => 'El correo del cliente es requerido',
            'people_email.email' => 'El correo del cliente debe ser un correo valido',
            'people_email.max' => 'El correo del cliente debe tener maximo 255 caracteres',
            'people_email.min' => 'El correo del cliente debe tener minimo 5 caracteres',
            'people_phone.required' => 'El telefono del cliente es requerido',
            'people_phone.string' => 'El telefono del cliente debe ser un texto',
            'people_phone.max' => 'El telefono del cliente debe tener maximo 255 caracteres',
            'people_phone.min' => 'El telefono del cliente debe tener minimo 6 caracteres',
            'people_address.required' => 'La direccion del cliente es requerido',
            'people_address.string' => 'La direccion del cliente debe ser un texto',
            'people_address.max' => 'La direccion del cliente debe tener maximo 255 caracteres',
            'people_address.min' => 'La direccion del cliente debe tener minimo 5 caracteres',
        ];
        $request->validate($rules, $messages);
        $people = '';
        if(!$request->input('people_id')){
            $people = new People();
            $people->name = $request->input('people_name');
            $people->nit = $request->input('people_nit');
            $people->email = $request->input('people_email');
            $people->phone = $request->input('people_phone');
            $people->address = $request->input('people_address');
            $people->type_people_id = 1;
            $people->save();
        }else {
           
            $people = People::find($request->input('people_id'));
            $people->update([
                'name' => $request->input('people_name'),
                'nit' => $request->input('people_nit'),
                'email' => $request->input('people_email'),
                'phone' => $request->input('people_phone'),
                'address' => $request->input('people_address'),
            ]);
        }

        $process = new Process();
        $process->name = $request->input('name');
        $process->radicate = $request->input('radicate');
        $process->description = $request->input('description');
        $process->user_id = auth()->user()->id;
        $process->people_id = $request->input('people_id') ? $request->input('people_id') : $people->id;
        $process->status = true;
        $process->save();
        return redirect()->route('processes.show', $process->id);
    }

    public function edit(Process $process)
    {
        $process->load('people');
        $people = People::all();
        return Inertia::render('Process/Edit', [
            'process' => $process,
            'people' => $people,
        ]);
    }

    public function update(Request $request, Process $process)
    {
        $rules = [];
        if(!$request->input('people_name')){
            $rules = [
                'name' => 'required|string|max:255|min:3',
                'radicate' => 'required|string|max:255|min:3',
                'description' => 'required|string|min:3',
                'people_id' => 'required|integer|exists:people,id',
            ];
        }else {

            $rules = [
                'name' => 'required|string|max:255|min:3',
                'radicate' => 'required|string|max:255|min:3',
                'description' => 'required|string|min:3',
                'people_name' => 'required|string|max:255|min:3',
                'people_nit' => 'required|string|max:255|min:5|unique:people,nit,'.$process->people_id,
                'people_email' => 'required|email|max:255|min:5',
                'people_phone' => 'required|string|max:255|min:6',
                'people_address' => 'required|string|max:255|min:5',
            ];
        }
        $messages = [
            'people_id.required' => 'El cliente es requerido',
            'people_id.integer' => 'El cliente debe ser un numero',
            'people_id.exists' => 'El cliente no existe',
            'people_name.required' => 'El nombre del cliente es requerido',
            'people_name.string' => 'El nombre del cliente debe ser un texto',
            'people_name.max' => 'El nombre del cliente debe tener maximo 255 caracteres',
            'people_name.min' => 'El nombre del cliente debe tener minimo 3 caracteres',
            'people_nit.required' => 'El documento del cliente es requerido',
            'people_nit.string' => 'El documento del cliente debe ser un texto',
            'people_nit.max' => 'El documento del cliente debe tener maximo 255 caracteres',
            'people_nit.min' => 'El documento del cliente debe tener minimo 5 caracteres',
            'people_nit.unique' => 'El documento del cliente ya existe',
            'people_email.required' => 'El correo del cliente es requerido',
            'people_email.email' => 'El correo del cliente debe ser un correo valido',
            'people_email.max' => 'El correo del cliente debe tener maximo 255 caracteres',
            'people_email.min' => 'El correo del cliente debe tener minimo 5 caracteres',
            'people_phone.required' => 'El telefono del cliente es requerido',
            'people_phone.string' => 'El telefono del cliente debe ser un texto',
            'people_phone.max' => 'El telefono del cliente debe tener maximo 255 caracteres',
            'people_phone.min' => 'El telefono del cliente debe tener minimo 6 caracteres',
            'people_address.required' => 'La direccion del cliente es requerido',
            'people_address.string' => 'La direccion del cliente debe ser un texto',
            'people_address.max' => 'La direccion del cliente debe tener maximo 255 caracteres',
            'people_address.min' => 'La direccion del cliente debe tener minimo 5 caracteres',
        ];
        $request->validate($rules, $messages);
        $people = '';
        if(!$request->input('people_id')){
            $people = new People();
            $people->name = $request->input('people_name');
            $people->nit = $request->input('people_nit');
            $people->email = $request->input('people_email');
            $people->phone = $request->input('people_phone');
            $people->address = $request->input('people_address');
            $people->type_people_id = 1;
            $people->save();
        }else {                   
            $people = People::find($request->input('people_id'));
            $people->update([
                'name' => $request->input('people_name'),
                'nit' => $request->input('people_nit'),
                'email' => $request->input('people_email'),
                'phone' => $request->input('people_phone'),
                'address' => $request->input('people_address'),
            ]);
        }
        $process->update([
            'name' => $request->input('name'),
            'radicate' => $request->input('radicate'),
            'description' => $request->input('description'),
            'user_id' => auth()->user()->id,
            'people_id' => $request->input('people_id') ? $request->input('people_id') : $people->id,
            'status' => true,
        ]);
        return redirect()->route('processes.show', $process->id);

    }

    public function destroy(Process $process)
    {
        $process->delete();
        return redirect()->route('processes');
    }
    
    public function changeStatus(Process $process)
    {

        $process->status = !$process->status;
        $process->save();

        $stages = Stage::where('process_id', $process->id)->get();
        foreach ($stages as $stage) {
            if($stage->status){
                $stage->status = !$stage->status;
                $stage->save();
            }
        }
        return redirect()->route('processes.show', $process->id);
    }
    
}


