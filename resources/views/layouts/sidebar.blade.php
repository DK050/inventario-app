{{-- resources/views/layouts/sidebar.blade.php --}}
<aside id="sidebar" class="sidebar absolute z-30 inset-y-0 left-0 w-64 bg-white shadow-md transform -translate-x-full md:relative md:translate-x-0 flex-shrink-0 flex flex-col">
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-xl font-bold text-pink-500">El Rincón Creativo ✨</h1>
            </div>
            <nav class="flex-grow pt-4">
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-gray-200 font-semibold">
                    <i class="fas fa-boxes-stacked w-6 text-center"></i>
                    <span class="ml-3">Inventario</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
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
                </a>
            </nav>
            <div class="p-4 border-t">
                <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span class="ml-3">Cerrar Sesión</span>
                </a>
            </div>
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
            
        </aside>

        