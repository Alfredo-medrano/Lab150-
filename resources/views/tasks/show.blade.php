<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de Tarea
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            <h3 class="text-2xl font-bold mb-4">{{ $task->title }}</h3>
            <p class="mb-4">{{ $task->description }}</p>
            <p><strong>Completada:</strong> {{ $task->completed ? 'Sí' : 'No' }}</p>
            <a href="{{ route('tasks.index') }}"
               class="mt-6 inline-block px-4 py-2 bg-gray-600 text-white rounded">
               Volver a la lista
            </a>
        </div>
    </div>
</x-app-layout>
