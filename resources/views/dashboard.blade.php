<x-app-layout>
    <x-slot name="header">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b flex items-center justify-between px-4 sm:px-6">
                <div class="flex items-center">
                    <!-- Mobile Menu Button -->
                    <button id="menu-button" class="md:hidden mr-3 text-gray-600 hover:text-gray-800">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Gestión de Inventario</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full object-cover" src="https://placehold.co/100x100/f8b4b4/ffffff?text=A" alt="Admin Avatar">
                        <span class="hidden sm:inline ml-2 text-sm font-medium">Admin</span>
                    </div>
                </div>
            </header>
    </x-slot>

    <div class="py-12">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- TODO EL CONTENIDO DE TUS CARDS, TABLA Y MODALES VA AQUÍ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Total de Productos</h4>
                            <p id='total-productos' class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Categorías</h4>
                            <p id='total-categorias' class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Poco Stock</h4>
                            <p id='poco-stock' class="text-3xl font-bold text-yellow-500">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Agotados</h4>
                            <p id='agotados' class="text-3xl font-bold text-red-500">0</p>
                    </div>

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-4 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                            <h3 class="text-lg font-semibold">Lista de Productos</h3>
                                <button id="addProductBtn" class="w-full sm:w-auto bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors flex items-center justify-center">                                        <i class="fas fa-plus mr-2"></i> Agregar Producto
                                </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full min-w-[640px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                <th class="hidden lg:table-cell p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="hidden sm:table-cell p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="inventory-table-body" class="bg-white divide-y divide-gray-200"></tbody>
                        
                    </table>
                </div>
                 {{-- <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-40 hidden modal-overlay-bg opacity-0">
                    <div id="modalContent" class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform scale-95 opacity-0 modal-content overflow-y-auto max-h-[90vh]">
                    <form id="productForm" class="p-6">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h2 id="modalTitle" class="text-2xl font-bold text-gray-800">Agregar Producto</h2>
                            <button id="closeModal" type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times fa-lg"></i>
                            </button>
                </div> --}}
                <!-- Add/Edit Product Modal -->
                <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-40 hidden modal-overlay-bg opacity-0">
                        <div id="modalContent" class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform scale-95 opacity-0 modal-content overflow-y-auto max-h-[90vh]">
                            <form id="productForm" class="p-6">
                                <div class="flex justify-between items-center border-b pb-3 mb-4">
                                    <h2 id="modalTitle" class="text-2xl font-bold text-gray-800">Agregar Producto</h2>
                                    <button id="closeModal" type="button" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-times fa-lg"></i>
                                    </button>
                                </div>
                
                        
                        <input type="hidden" id="productId">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="productName" class="block text-sm font-medium text-gray-700">Nombre del Producto</label>
                                <input type="text" id="productName" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
                            </div>
                            <div>
                                <label for="productCategory" class="block text-sm font-medium text-gray-700">Categoría</label>
                                <select id="productCategory" class="mt-1 w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
                                    <option>Papelería</option>
                                    <option>Regalos</option>
                                    <option>Adornos</option>
                                    <option>Maquetas</option>
                                </select>
                            </div>
                            <div>
                                <label for="productPrice" class="block text-sm font-medium text-gray-700">Precio</label>
                                <input type="number" id="productPrice" min="0" step="0.01" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
                            </div>
                            <div>
                                <label for="productStock" class="block text-sm font-medium text-gray-700">Cantidad en Stock</label>
                                <input type="number" id="productStock" min="0" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
                            </div>
                            <div class="md:col-span-2">
                                <label for="productImage" class="block text-sm font-medium text-gray-700">URL de la Imagen</label>
                                <input type="text" id="productImage" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" placeholder="https://example.com/imagen.jpg">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancelModalBtn" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">Cancelar</button>
                            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/inventory.js') }}"></script>
    </div>
</x-app-layout>
