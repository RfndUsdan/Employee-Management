<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-32 h-32 rounded-full">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $employee->full_name }}</h1>
                        <p class="text-gray-600">{{ $employee->position->name }} - {{ $employee->department->name }}</p>
                        <hr class="my-4">
                        <p><strong>Email:</strong> {{ $employee->email }}</p>
                        <p><strong>Telepon:</strong> {{ $employee->phone }}</p>
                        <p><strong>Tanggal Bergabung:</strong> {{ $employee->join_date }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>