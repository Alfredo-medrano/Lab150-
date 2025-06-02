<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis tareas
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <form action="{{ route('tasks.index') }}" method="GET" class="mb-4">
                <div class="flex items-center">
                    <input type="text" name="search" placeholder="Buscar tareas..." value="{{ request('search') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">

                    <select name="priority" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2">
                        <option value="">Todas las prioridades</option>
                        <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>Alta</option>
                        <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Media</option>
                        <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>Normal</option>
                        <option value="4" {{ request('priority') == '4' ? 'selected' : '' }}>Baja</option>
                        <option value="5" {{ request('priority') == '5' ? 'selected' : '' }}>Muy Baja</option>
                    </select>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                        Buscar
                    </button>
                    <a href="{{ route('tasks.index') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none focus:shadow-outline">
                        Limpiar
                    </a>
                </div>
            </form>

            <a href="{{ route('tasks.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Nueva tarea</a>
        </div>

        @if (session('success'))
            <div class="bg-green-200 border-green-500 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioridad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completada</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($task->priority)
                                @case(1)
                                    Alta
                                    @break
                                @case(2)
                                    Media
                                    @break
                                @case(3)
                                    Normal
                                    @break
                                @case(4)
                                    Baja
                                    @break
                                @case(5)
                                    Muy Baja
                                    @break
                                @default
                                    Desconocida
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="checkbox" name="completed" value="1" {{ $task->completed ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('tasks.show', $task->id) }}" >Ver</a>
                            <a href="{{ route('tasks.edit', $task->id) }}">Editar</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay tareas</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>