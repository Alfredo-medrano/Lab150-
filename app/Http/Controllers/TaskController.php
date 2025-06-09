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
     * Mostrar listado de tareas del usuario autenticado, aplicando filtros por búsqueda y prioridad.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $query = $user->tasks();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->latest()->get();

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
            'priority'    => 'required|integer|min:1|max:5', 
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->tasks()->create($data);

        return redirect()->route('tasks.index');
    }

    /**
     * Mostrar los detalles de una tarea.
     */
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
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|integer|min:1|max:5'
        ]);

        // Si el checkbox está marcado, 'completed' será true; en caso contrario, false.
        $data['completed'] = $request->has('completed');

        $task->update($data);

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Eliminar la tarea de la base de datos.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                         ->with('success', 'Tarea eliminada correctamente.');
    }
}