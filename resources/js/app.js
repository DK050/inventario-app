import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// --- INVENTORY MANAGEMENT APP ---
document.addEventListener('DOMContentLoaded', () => {
    let inventory = window.initialProducts || [];

    const fetchProducts = async () => {
        try {
            // ✅ LA CORRECCIÓN FINAL ESTÁ AQUÍ
            // Añadimos la cabecera 'Accept' para decirle explícitamente
            // a Laravel que queremos una respuesta en formato JSON.
            const res = await fetch('/products', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Header extra para robustez
                }
            });

            if (!res.ok) throw new Error('Error al refrescar productos');

            inventory = await res.json();
            renderTable();
        } catch (err) {
            const tableBody = document.getElementById('inventory-table-body');
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-red-500">Error al refrescar productos</td></tr>`;
            }
            console.error(err); // Dejamos un log del error por si acaso
        }
    };

    // --- DOM Elements (sin cambios) ---
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('menu-button');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const tableBody = document.getElementById('inventory-table-body');
    const addProductBtn = document.getElementById('addProductBtn');
    const productForm = document.getElementById('productForm');
    const modalTitle = document.getElementById('modalTitle');

    // --- Logic (sin cambios) ---
    function toggleSidebar() {
        if (sidebar && sidebarOverlay) {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
    }
    if (menuButton) menuButton.addEventListener('click', toggleSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

    const openReusableModal = (name) => window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
    const closeReusableModal = (name) => window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));

    const getStatusBadge = (stock) => {
        if (stock === 0) return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Agotado</span>';
        if (stock <= 10) return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Poco Stock</span>';
        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">En Stock</span>';
    };

    const renderTable = () => {
        if (!tableBody) return;
        tableBody.innerHTML = '';
        if (!inventory || inventory.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-gray-500">No hay productos en el inventario.</td></tr>`;
        } else {
            inventory.forEach(product => {
                const row = `
                    <tr id="product-${product.id}">
                        <td class="p-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10"><img src="${product.image}" alt="" class="w-10 h-10 rounded-md object-cover" onerror="this.onerror=null;this.src='https://placehold.co/100x100/e0e0e0/ffffff?text=Img';"></div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">${product.name}</div>
                                    <div class="text-sm text-gray-500 lg:hidden">${product.category}</div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden lg:table-cell p-4 whitespace-nowrap text-sm text-gray-500">${product.category}</td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(product.price).toFixed(2)}</td>
                        <td class="p-4 whitespace-nowrap text-sm text-gray-900 font-medium">${product.stock}</td>
                        <td class="hidden sm:table-cell p-4 whitespace-nowrap">${getStatusBadge(product.stock)}</td>
                        <td class="p-4 whitespace-nowrap text-sm font-medium">
                            <button data-id="${product.id}" class="edit-btn text-indigo-600 hover:text-indigo-900 mr-3" aria-label="Editar"><i class="fas fa-edit fa-fw"></i></button>
                            <button data-id="${product.id}" class="delete-btn text-red-600 hover:text-red-900" aria-label="Eliminar"><i class="fas fa-trash fa-fw"></i></button>
                        </td>
                    </tr>`;
                tableBody.innerHTML += row;
            });
        }
        updateStats();
        attachActionListeners();
    };

    const updateStats = () => {
        const totalProductosEl = document.getElementById('total-productos');
        const totalCategoriasEl = document.getElementById('total-categorias');
        const pocoStockEl = document.getElementById('poco-stock');
        const agotadosEl = document.getElementById('agotados');

        if (totalProductosEl) totalProductosEl.textContent = inventory.length;
        if (totalCategoriasEl) {
            const categories = new Set(inventory.map(p => p.category));
            totalCategoriasEl.textContent = categories.size;
        }
        if (pocoStockEl) pocoStockEl.textContent = inventory.filter(p => p.stock > 0 && p.stock <= 10).length;
        if (agotadosEl) agotadosEl.textContent = inventory.filter(p => p.stock === 0).length;
    };

    const showAddModal = () => {
        if (productForm) {
            productForm.reset();
            document.getElementById('productId').value = '';
        }
        if (modalTitle) modalTitle.textContent = 'Agregar Nuevo Producto';
        openReusableModal('product-modal');
    };

    const showEditModal = (id) => {
        const product = inventory.find(p => p.id === id);
        if (product && productForm) {
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productCategory').value = product.category;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            document.getElementById('productImage').value = product.image;
            if (modalTitle) modalTitle.textContent = 'Editar Producto';
            openReusableModal('product-modal');
        }
    };

    const handleFormSubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('productId').value;
        const productData = {
            name: document.getElementById('productName').value,
            category: document.getElementById('productCategory').value,
            price: parseFloat(document.getElementById('productPrice').value),
            stock: parseInt(document.getElementById('productStock').value),
            image: document.getElementById('productImage').value || 'https://placehold.co/100x100/e0e0e0/ffffff?text=Img'
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const url = id ? `/products/${id}` : '/products';
            const method = id ? 'PUT' : 'POST';
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(productData)
            });

            if (!res.ok) {
                const errorData = await res.json();
                console.error('Error del servidor:', errorData);
                throw new Error('Error al guardar producto');
            }
            closeReusableModal('product-modal');
            await fetchProducts(); // Refresca la tabla después de guardar
        } catch (err) {
            alert('Error al guardar producto. Revisa la consola del navegador.');
        }
    };

    const deleteProduct = async (id) => {
        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const res = await fetch(`/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                });
                if (!res.ok) throw new Error('Error al eliminar producto');
                await fetchProducts(); // Refresca la tabla después de eliminar
            } catch (err) {
                alert('Error al eliminar producto');
            }
        }
    };

    // --- Listeners (sin cambios) ---
    function handleEditClick(e) {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        showEditModal(id);
    }
    function handleDeleteClick(e) {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        deleteProduct(id);
    }

    const attachActionListeners = () => {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.removeEventListener('click', handleEditClick);
            button.addEventListener('click', handleEditClick);
        });
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.removeEventListener('click', handleDeleteClick);
            button.addEventListener('click', handleDeleteClick);
        });
    };

    if (addProductBtn) {
        addProductBtn.addEventListener('click', () => showAddModal());
    }

    const closeModalBtn = document.getElementById('closeModal');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    if (closeModalBtn) closeModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));

    if (productForm) productForm.addEventListener('submit', handleFormSubmit);

    // ✅ CARGA INICIAL DIRECTA:
    renderTable();
});
