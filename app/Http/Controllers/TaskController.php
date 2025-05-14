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
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->tasks()->create($data);

        return redirect()->route('tasks.index');
    }
}
