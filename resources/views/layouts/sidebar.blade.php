{{-- resources/views/layouts/sidebar.blade.php --}}
<aside id="sidebar" class="sidebar flex flex-col md:relative md:w-64 min-h-screen bg-white shadow-md flex-shrink-0">
    <div class="h-16 flex items-center justify-center border-b">
        <a href="{{ url('/') }}" class="text-xl font-bold text-pink-500 hover:text-pink-600 transition-colors">El
            Rincón Creativo ✨</a>
    </div>
    <nav class="flex-1 pt-4">
        <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
            <i class="fas fa-boxes-stacked w-6 text-center"></i>
            <span class="ml-3">Inventario</span>
        </a>
        {{-- <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-receipt w-6 text-center"></i>
            <span class="ml-3">Pedidos</span>
        </a>
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-users w-6 text-center"></i>
            <span class="ml-3">Clientes</span>
        </a>
        <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-chart-pie w-6 text-center"></i>
            <span class="ml-3">Reportes</span>
        </a> --}}
    </nav>
    <div class="p-4 border-t mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <i class="fas fa-sign-out-alt w-6 text-center text-red-600"></i>
            <button type="submit">Cerrar sesión</button>
        </form>
        {{-- <a href="#" class="flex items-center px-4 py-2 text-red-600 hover:bg-gray-100 rounded-md">
            <i class="fas fa-sign-out-alt w-6 text-center"></i>
            <span class="ml-3">Cerrar Sesión</span>
        </a> --}}
    </div>
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden hidden"></div>
</aside>
