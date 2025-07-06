import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// --- INVENTORY MANAGEMENT APP ---
// File: resources/js/inventory.js
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
        if(menuButton) menuButton.addEventListener('click', toggleSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

        // --- Modal Reutilizable Logic ---
        const openReusableModal = (name) => {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
        };
        const closeReusableModal = (name) => {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
        };

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
                    const row =` 
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
                     `;
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
        // --- Modal Event Listeners ---
        if(addProductBtn) {
            addProductBtn.addEventListener('click', () => {
                showAddModal();
                openReusableModal('product-modal');
            });
        }
        if(closeModalBtn) closeModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));
        if(cancelModalBtn) cancelModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));
        if(productForm) productForm.addEventListener('submit', handleFormSubmit);

        // --- Initial Load ---
        renderTable();
    });
    