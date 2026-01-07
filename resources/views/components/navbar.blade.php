<nav class="bg-white shadow-md mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-blue-600 tracking-tight">DIREKTORI</a>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <a href="/admin" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Dashboard Admin</a>
                    
                    @if(auth()->user()->employee)
                        <a href="{{ route('employee.show', auth()->user()->employee->id) }}" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Profil Saya</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>