import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// --- INVENTORY MANAGEMENT APP ---
document.addEventListener('DOMContentLoaded', () => {
    let inventory = [];

    // ✅ CORRECCIÓN: Simplificamos el helper de la URL. Ya no es necesario.
    const getApiUrl = (path) => path;

    const fetchProducts = async () => {
        try {
            // Usamos la ruta web '/products' que apunta al método 'index' del controlador
            const res = await fetch(getApiUrl('/products'));
            if (!res.ok) throw new Error('Error al cargar productos');
            inventory = await res.json();
            renderTable();
        } catch (err) {
            const tableBody = document.getElementById('inventory-table-body');
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-red-500">Error al cargar productos</td></tr>`;
            }
        }
    };

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
        if (sidebar && sidebarOverlay) {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
    }
    if (menuButton) menuButton.addEventListener('click', toggleSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

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
        if (!tableBody) return;
        tableBody.innerHTML = '';
        if (inventory.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-gray-500">No hay productos en el inventario.</td></tr>`;
        } else {
            inventory.forEach(product => {
                const row = `
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
                        <td class="p-4 whitespace-nowrap text-sm text-gray-500">$${parseFloat(product.price).toFixed(2)}</td>
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

        // ✅ CORRECCIÓN: Obtenemos el token CSRF de la etiqueta <meta> que pusimos en el layout.
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            let res;
            const url = id ? `/products/${id}` : '/products';
            const method = id ? 'PUT' : 'POST';

            res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // ✅ CORRECCIÓN: Enviamos el token CSRF correcto en la cabecera.
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
            await fetchProducts();
        } catch (err) {
            alert('Error al guardar producto. Revisa la consola del navegador para más detalles.');
        }
    };

    const deleteProduct = async (id) => {
        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
            // ✅ CORRECCIÓN: Obtenemos el token CSRF también para la petición de borrado.
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const res = await fetch(`/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        // ✅ CORRECCIÓN: Y lo enviamos aquí también.
                        'X-CSRF-TOKEN': csrfToken,
                    }
                });
                if (!res.ok) throw new Error('Error al eliminar producto');
                await fetchProducts();
            } catch (err) {
                alert('Error al eliminar producto');
            }
        }
    };

    const attachActionListeners = () => {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.removeEventListener('click', handleEditClick); // Prevenir duplicados
            button.addEventListener('click', handleEditClick);
        });
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.removeEventListener('click', handleDeleteClick); // Prevenir duplicados
            button.addEventListener('click', handleDeleteClick);
        });
    };

    // Helpers para evitar listeners duplicados
    function handleEditClick(e) {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        showEditModal(id);
    }
    function handleDeleteClick(e) {
        const id = parseInt(e.currentTarget.getAttribute('data-id'));
        deleteProduct(id);
    }

    // --- Event Listeners ---
    if (addProductBtn) {
        addProductBtn.addEventListener('click', () => {
            showAddModal();
        });
    }
    if (closeModalBtn) closeModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', () => closeReusableModal('product-modal'));
    if (productForm) productForm.addEventListener('submit', handleFormSubmit);

    // --- Initial Load ---
    fetchProducts();
});
