<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Inventario') }} {{-- Cambiado de 'Dashboard' a 'Gestión de Inventario' --}}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{-- TODO EL CONTENIDO DE TUS CARDS, TABLA Y MODALES VA AQUÍ --}}

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Total de Productos</h4>
                            <p id="total-productos" class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Categorías</h4>
                            <p id="total-categorias" class="text-3xl font-bold text-gray-800">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Poco Stock</h4>
                            <p id="poco-stock" class="text-3xl font-bold text-yellow-500">0</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h4 class="text-gray-500">Agotados</h4>
                            <p id="agotados" class="text-3xl font-bold text-red-500">0</p>
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
                 <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-40 hidden modal-overlay-bg opacity-0">
                    <div id="modalContent" class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform scale-95 opacity-0 modal-content overflow-y-auto max-h-[90vh]">
                    <form id="productForm" class="p-6">
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h2 id="modalTitle" class="text-2xl font-bold text-gray-800">Agregar Producto</h2>
                            <button id="closeModal" type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times fa-lg"></i>
                            </button>
                </div>
                {{-- Tu modal de producto (productModal) puede estar aquí mismo o al final del body en app.blade.php --}}
                {{-- Si el modal no se ve bien o se corta, prueba moverlo al final del <body> en app.blade.php --}}
                {{-- Por ahora, manténlo aquí y si da problemas, lo movemos. --}}
                
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- MOCK DATA ---
        let inventory = [
            { id: 1, name: 'Set de Stickers Florales', category: 'Papelería', price: 5.99, stock: 45, image: 'https://placehold.co/100x100/dcfce7/16a34a?text=Stickers' },
            { id: 2, name: 'Taza Personalizada "Te Quiero"', category: 'Regalos', price: 12.50, stock: 20, image: 'https://placehold.co/100x100/fecdd3/ef4444?text=Taza' },
            { id: 3, name: 'Guirnalda de Luces LED', category: 'Adornos', price: 8.00, stock: 8, image: 'https://placehold.co/100x100/fef08a/ca8a04?text=Luces' },
            { id: 4, name: 'Maqueta Sistema Solar', category: 'Maquetas', price: 25.00, stock: 5, image: 'https://placehold.co/100x100/bfdbfe/3b82f6?text=Maqueta' },
            { id: 5, name: 'Libreta de Puntos A5', category: 'Papelería', price: 7.25, stock: 60, image: 'https://placehold.co/100x100/dcfce7/16a34a?text=Libreta' },
            { id: 6, name: 'Caja Sorpresa de Cumpleaños', category: 'Regalos', price: 30.00, stock: 0, image: 'https://placehold.co/100x100/fecdd3/ef4444?text=Caja' },
        ];

        // --- DOM Elements ---
        const sidebar = document.getElementById('sidebar');
        const menuButton = document.getElementById('menu-button');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const tableBody = document.getElementById('inventory-table-body');
        const addProductBtn = document.getElementById('addProductBtn');
        const productModal = document.getElementById('productModal');
        const modalContent = document.getElementById('modalContent');
        const closeModalBtn = document.getElementById('closeModal');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const productForm = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');

        // --- Responsive Sidebar Logic ---
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
        menuButton.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        
        // --- Functions ---
        const getStatusBadge = (stock) => {
            if (stock === 0) return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Agotado</span>';
            if (stock <= 10) return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Poco Stock</span>';
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">En Stock</span>';
        };

        const renderTable = () => {
            tableBody.innerHTML = '';
            if (inventory.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-gray-500">No hay productos en el inventario.</td></tr>`;
            } else {
                inventory.forEach(product => {
                    const row = 
                        <tr id="product-${product.id}">
                            <td class="p-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img src="${product.image}" alt="" class="w-10 h-10 rounded-md object-cover" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e0e0e0/ffffff?text=Img';">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                        <div class="text-sm text-gray-500 lg:hidden">${product.category}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden lg:table-cell p-4 whitespace-nowrap text-sm text-gray-500">${product.category}</td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">$${product.price.toFixed(2)}</td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-900 font-medium">${product.stock}</td>
                            <td class="hidden sm:table-cell p-4 whitespace-nowrap">${getStatusBadge(product.stock)}</td>
                            <td class="p-4 whitespace-nowrap text-sm font-medium">
                                <button data-id="${product.id}" class="edit-btn text-indigo-600 hover:text-indigo-900 mr-3" aria-label="Editar"><i class="fas fa-edit fa-fw"></i></button>
                                <button data-id="${product.id}" class="delete-btn text-red-600 hover:text-red-900" aria-label="Eliminar"><i class="fas fa-trash fa-fw"></i></button>
                            </td>
                        </tr>
                    ;
                    tableBody.innerHTML += row;
                });
            }
            updateStats();
            attachActionListeners();
        };
        
        const updateStats = () => {
            document.getElementById('total-productos').textContent = inventory.length;
            const categories = new Set(inventory.map(p => p.category));
            document.getElementById('total-categorias').textContent = categories.size;
            document.getElementById('poco-stock').textContent = inventory.filter(p => p.stock > 0 && p.stock <= 10).length;
            document.getElementById('agotados').textContent = inventory.filter(p => p.stock === 0).length;
        };
        
        const openModal = () => {
            productModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                productModal.classList.remove('opacity-0');
                modalContent.classList.remove('opacity-0', 'scale-95');
            }, 10);
        };

        const closeModal = () => {
            modalContent.classList.add('opacity-0', 'scale-95');
            productModal.classList.add('opacity-0');
            setTimeout(() => {
                productModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        };
        
        const showAddModal = () => {
            productForm.reset();
            document.getElementById('productId').value = '';
            modalTitle.textContent = 'Agregar Nuevo Producto';
            openModal();
        };

        const showEditModal = (id) => {
            const product = inventory.find(p => p.id === id);
            if(product) {
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productStock').value = product.stock;
                document.getElementById('productImage').value = product.image;
                modalTitle.textContent = 'Editar Producto';
                openModal();
            }
        };
        
        const handleFormSubmit = (e) => {
            e.preventDefault();
            const id = document.getElementById('productId').value;
            const productData = {
                name: document.getElementById('productName').value,
                category: document.getElementById('productCategory').value,
                price: parseFloat(document.getElementById('productPrice').value),
                stock: parseInt(document.getElementById('productStock').value),
                image: document.getElementById('productImage').value || 'https://placehold.co/100x100/e0e0e0/ffffff?text=Img'
            };

            if (id) { // Editing
                const index = inventory.findIndex(p => p.id == id);
                inventory[index] = { ...inventory[index], ...productData };
            } else { // Adding
                const newId = inventory.length > 0 ? Math.max(...inventory.map(p => p.id)) + 1 : 1;
                inventory.unshift({ id: newId, ...productData }); // Add to the top
            }
            
            closeModal();
            renderTable();
        };

        const deleteProduct = (id) => {
            if(confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                inventory = inventory.filter(p => p.id !== id);
                renderTable();
            }
        };
        
        const attachActionListeners = () => {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = parseInt(e.currentTarget.getAttribute('data-id'));
                    showEditModal(id);
                });
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = parseInt(e.currentTarget.getAttribute('data-id'));
                    deleteProduct(id);
                });
            });
        };

        // --- Event Listeners ---
        addProductBtn.addEventListener('click', showAddModal);
        closeModalBtn.addEventListener('click', closeModal);
        cancelModalBtn.addEventListener('click', closeModal);
        productForm.addEventListener('submit', handleFormSubmit);
        
        document.addEventListener('keydown', (e) => e.key === "Escape" && !productModal.classList.contains('hidden') && closeModal());
        productModal.addEventListener('click', (e) => e.target === productModal && closeModal());

        // --- Initial Load ---
        renderTable();
    });
    </script>
</x-app-layout>
