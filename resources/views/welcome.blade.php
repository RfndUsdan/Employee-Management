<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <x-navbar />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Direktori Karyawan</h1>
            <p class="text-gray-600">Temukan rekan kerja Anda dengan mudah</p>
        </header>

        <form action="/" method="GET" class="mb-8 max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari nama karyawan..." 
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="w-full md:w-64">
                    <select name="department_id" onchange="this.form.submit()" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition">
                    Cari
                </button>
                
                @if(request('search') || request('department_id'))
                    <a href="/" class="text-red-500 flex items-center justify-center text-sm underline">Reset</a>
                @endif
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($employees as $employee)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6 text-center">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->full_name }}" 
                             class="w-24 h-24 rounded-full mx-auto object-cover mb-4 border-4 border-blue-50">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto flex items-center justify-center mb-4">
                            <span class="text-gray-400 text-3xl font-bold">{{ substr($employee->full_name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <h2 class="text-lg font-bold text-gray-800">{{ $employee->full_name }}</h2>
                    <p class="text-blue-600 font-medium text-sm mb-1">{{ $employee->position->name }}</p>
                    <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">{{ $employee->department->name }}</p>
                    
                    <div class="pt-4 border-t border-gray-100 flex justify-center space-x-4 text-gray-600">
                        <span class="text-sm">📞 {{ $employee->phone }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $employees->links() }}
        </div>
    </div>

</body>
</html>