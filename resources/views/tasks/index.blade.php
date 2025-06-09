<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis tareas
            </h2>
            <a href="{{ route('tasks.create') }}"
               class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded hover:from-blue-600 hover:to-blue-800 transition duration-150 ease-in-out">
                Nueva tarea
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Filtros -->
        <div class="mb-6 bg-white p-4 rounded shadow">
            <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                <input type="text" name="search" placeholder="Buscar tareas..."
                       value="{{ request('search') }}"
                       class="shadow appearance-none border rounded w-full md:w-1/3 py-2 px-3 text-gray-700">
                <select name="priority" class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                    <option value="">Todas las prioridades</option>
                    <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>Alta</option>
                    <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Media</option>
                    <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>Normal</option>
                    <option value="4" {{ request('priority') == '4' ? 'selected' : '' }}>Baja</option>
                    <option value="5" {{ request('priority') == '5' ? 'selected' : '' }}>Muy Baja</option>
                </select>
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-150 ease-in-out transform hover:scale-105">
                    Buscar
                </button>
                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-150 ease-in-out transform hover:scale-105">
                    Limpiar
                </a>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-200 border-green-500 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Lista de tareas -->
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
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($task->priority)
                                    @case(1)
                                        <span class="text-red-500 font-bold">Alta</span>
                                        @break
                                    @case(2)
                                        <span class="text-orange-500 font-bold">Media</span>
                                        @break
                                    @case(3)
                                        <span class="text-blue-500 font-bold">Normal</span>
                                        @break
                                    @case(4)
                                        <span class="text-green-500 font-bold">Baja</span>
                                        @break
                                    @case(5)
                                        <span class="text-gray-500 font-bold">Muy Baja</span>
                                        @break
                                    @default
                                        Desconocida
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form id="task-form-{{ $task->id }}" action="{{ route('tasks.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- Campo oculto para enviar la prioridad actual y pasar la validación -->
                                    <input type="hidden" name="priority" value="{{ $task->priority }}">
                                    <input type="checkbox" name="completed" value="1" {{ $task->completed ? 'checked' : '' }}
                                           class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('tasks.show', $task->id) }}"
                                    class="px-3 py-1 bg-gradient-to-r from-green-500 to-green-600 text-white rounded shadow hover:from-green-600 hover:to-green-700 transition duration-150 ease-in-out">
                                        Ver
                                    </a>
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded shadow hover:from-blue-600 hover:to-blue-700 transition duration-150 ease-in-out">
                                        Editar
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white rounded shadow hover:from-red-600 hover:to-red-700 transition duration-150 ease-in-out">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No hay tareas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>