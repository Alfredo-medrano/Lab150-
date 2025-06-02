<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Tarea
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                        <input type="text" name="title" id="title" value="{{ $task->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $task->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Prioridad:</label>
                        <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Alta</option>
                            <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Media</option>
                            <option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>Normal</option>
                            <option value="4" {{ $task->priority == 4 ? 'selected' : '' }}>Baja</option>
                            <option value="5" {{ $task->priority == 5 ? 'selected' : '' }}>Muy Baja</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="completed" class="block text-gray-700 text-sm font-bold mb-2">Completada:</label>
                        <input type="checkbox" name="completed" id="completed" value="1" {{ $task->completed ? 'checked' : '' }}>
                    </div>

                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Actualizar
                        </button>
                        <a href="{{ route('tasks.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>