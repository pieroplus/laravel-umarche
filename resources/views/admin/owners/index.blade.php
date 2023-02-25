<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Eloquent<br>
                    @foreach($eAll as $e)
                      {{ $e->name }}<br>
                      {{ $e->created_at->diffForHumans() }}<br>
                    @endforeach
                    <br><br>
                    QueryBuilder<br>
                    @foreach($qGet as $q)
                      {{ $q->name }}<br>
                      {{ \Carbon\Carbon::parse($q->created_at)->diffForHumans() }}<br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
