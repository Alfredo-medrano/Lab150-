<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin \Illuminate\Routing\Controller
 */
class TaskController extends Controller
{
    public function __construct()
    {
        // Aplica middleware de autenticación
        $this->middleware('auth');
    }

    /**
     * Mostrar listado de tareas del usuario autenticado.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tasks = $user->tasks()->latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Formulario para crear una nueva tarea.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Almacenar la tarea creada en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|integer|min:1|max:5', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->tasks()->create($data);

        return redirect()->route('tasks.index');
    }



    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

     /**
     * Mostrar el formulario para editar una tarea.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Actualizar la tarea en la base de datos.
     */

    public function update(Request $request, Task $task)
    {

        $data = $request->validate([
            'completed' => 'sometimes|boolean',
            'priority' => 'required|integer|min:1|max:5',
        ]);

        $task->update([
            'completed' => $request->has('completed') ? true : false,
            'priority' => $request->input('priority'),
        ]);


        return redirect()->route('tasks.index');
    }

    /**
     * Eliminar la tarea de la base de datos.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}