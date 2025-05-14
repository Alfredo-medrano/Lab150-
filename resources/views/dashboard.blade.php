<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tareas Completadas') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
            @if($tasks->isEmpty())
                <p class="text-gray-500">No tienes tareas completadas todavía.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <li class="py-3 flex justify-between">
                            <span>{{ $task->title }}</span>
                            <span class="text-green-600 font-semibold">✓</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
