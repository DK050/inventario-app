<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Rincón Creativo - Regalos, Papelería y Proyectos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-bg {
            background-image: linear-gradient(to right, rgba(255, 242, 242, 0.95), rgba(235, 248, 255, 0.95)), url('https://placehold.co/1200x800/f8b4b4/ffffff?text=Fondo+Creativo');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 hide-scrollbar">
<script>
    // Asegura que la clase se aplique también al elemento html
    document.addEventListener('DOMContentLoaded', function () {
        document.documentElement.classList.add('hide-scrollbar');
    });
</script>

    <!-- Header & Navigation -->
    <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-pink-500 hover:text-pink-600 transition-colors">
                El Rincón Creativo ✨
            </a>
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-600 hover:text-pink-500 transition-colors">Inicio</a>
                <a href="#productos" class="text-gray-600 hover:text-pink-500 transition-colors">Productos</a>
                <a href="#servicios" class="text-gray-600 hover:text-pink-500 transition-colors">Servicios</a>
                <a href="#nosotros" class="text-gray-600 hover:text-pink-500 transition-colors">Nosotros</a>
                <a href="#contacto" class="text-gray-600 hover:text-pink-500 transition-colors">Contacto</a>
            </div>
            <!-- Login/Dashboard Button -->
            <div class="flex items-center">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-pink-500 text-white px-4 py-2 rounded-full hover:bg-pink-600 transition-transform transform hover:scale-105">
                            Ir al Dashboard
                        </a>
                    @else
                        <button id="open-login-modal" type="button" class="bg-pink-500 text-white px-4 py-2 rounded-full hover:bg-pink-600 transition-transform transform hover:scale-105 focus:outline-none">
                            Iniciar Sesión
                        </button>
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    {{-- ...pega aquí el resto de tu homepage (hero, categorías, servicios, nosotros, footer)... --}}
    <!-- Hero Section -->
    <section class="hero-bg py-20 md:py-32">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4 leading-tight">
                Donde la Creatividad Cobra Vida
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                Regalos únicos, papelería adorable y la ayuda que necesitas para tus proyectos escolares. ¡Todo en un solo lugar!
            </p>
            <a href="#productos" class="bg-blue-500 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-blue-600 transition-transform transform hover:scale-105 inline-block">
                Explora Ahora
            </a>
        </div>
    </section>
     <!-- Categories Section -->
        <section id="productos" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold text-center mb-2">Nuestras Categorías</h2>
                <p class="text-center text-gray-500 mb-12">Encuentra justo lo que buscas.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Category Card 1 -->
                    <div class="bg-pink-50 rounded-lg p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <img src="https://placehold.co/300x200/fecdd3/ef4444?text=Regalos" alt="Regalos Personalizados" class="w-full h-40 object-cover rounded-md mb-4 mx-auto">
                        <h3 class="text-xl font-semibold mb-2 text-pink-800">Regalos Únicos</h3>
                        <p class="text-gray-600">Sorprende a esa persona especial con detalles inolvidables.</p>
                    </div>
                    <!-- Category Card 2 -->
                    <div class="bg-blue-50 rounded-lg p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <img src="https://placehold.co/300x200/bfdbfe/3b82f6?text=Papelería" alt="Papelería" class="w-full h-40 object-cover rounded-md mb-4 mx-auto">
                        <h3 class="text-xl font-semibold mb-2 text-blue-800">Papelería Bonita</h3>
                        <p class="text-gray-600">Cuadernos, stickers y todo para organizar tus ideas con estilo.</p>
                    </div>
                    <!-- Category Card 3 -->
                    <div class="bg-yellow-50 rounded-lg p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <img src="https://placehold.co/300x200/fef08a/ca8a04?text=Adornos" alt="Adornos" class="w-full h-40 object-cover rounded-md mb-4 mx-auto">
                        <h3 class="text-xl font-semibold mb-2 text-yellow-800">Adornos y Fiestas</h3>
                        <p class="text-gray-600">Dale un toque mágico a tus celebraciones y espacios.</p>
                    </div>
                    <!-- Category Card 4 -->
                    <div class="bg-green-50 rounded-lg p-6 text-center shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <img src="https://placehold.co/300x200/dcfce7/16a34a?text=Maquetas" alt="Proyectos Escolares" class="w-full h-40 object-cover rounded-md mb-4 mx-auto">
                        <h3 class="text-xl font-semibold mb-2 text-green-800">Ayuda Escolar</h3>
                        <p class="text-gray-600">Maquetas y trabajos creativos para sacar la mejor nota.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="servicios" class="py-16">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row items-center bg-white rounded-xl shadow-xl overflow-hidden">
                    <div class="w-full md:w-1/2">
                        <img src="https://placehold.co/600x400/a5b4fc/4338ca?text=Proyecto+Escolar" alt="Niña feliz con su maqueta" class="w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 p-8 md:p-12">
                        <h2 class="text-3xl font-bold mb-4">¿Necesitas Ayuda con una Maqueta?</h2>
                        <p class="text-gray-600 mb-6">Sabemos que los proyectos escolares pueden ser un desafío. ¡Estamos aquí para ayudarte! Hacemos maquetas, carteleras y todo tipo de trabajos manuales con creatividad y dedicación.</p>
                        <a href="#contacto" class="bg-green-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-600 transition-transform transform hover:scale-105 inline-block">
                            Cotiza tu Proyecto
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section id="nosotros" class="py-16 bg-pink-50">
             <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-center mb-4">Nuestra Pasión</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    El Rincón Creativo nació del amor por crear y el deseo de compartir alegría. Cada producto y servicio que ofrecemos está hecho con dedicación, pensando en sacar una sonrisa y hacer la vida un poco más bonita y fácil.
                </p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contacto" class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-semibold mb-4">El Rincón Creativo</h3>
            <p class="mb-4">¡Hablemos! Estamos listos para tu próxima idea.</p>
            <p class="mb-6 font-semibold text-pink-300">contacto@rinconcreativo.com | +57 300 123 4567</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="hover:text-pink-400 transition-colors">Facebook</a>
                <a href="#" class="hover:text-pink-400 transition-colors">Instagram</a>
                <a href="#" class="hover:text-pink-400 transition-colors">WhatsApp</a>
            </div>
            <p class="mt-8 text-sm text-gray-400">&copy; 2024 El Rincón Creativo. Todos los derechos reservados.</p>
        </div>
    </footer>
<!-- Login Modal -->
<div id="login-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-8 relative">
        <button id="close-login-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
        <h2 class="text-2xl font-bold mb-6 text-center text-pink-500">Iniciar Sesión</h2>
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input id="email" class="block mt-1 w-full rounded border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input id="password" class="block mt-1 w-full rounded border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" class="rounded border-gray-400 text-pink-600 shadow-sm focus:ring-pink-400" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Recuérdame</label>
            </div>
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-pink-500" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
                <button type="submit" class="ml-3 bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition-colors">Entrar</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('open-login-modal');
        const closeBtn = document.getElementById('close-login-modal');
        const modal = document.getElementById('login-modal');
        if (openBtn && closeBtn && modal) {
            openBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });
            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
            // Cerrar modal al hacer clic fuera del contenido
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }
        // Abrir modal automáticamente si hay errores o status
        @if ($errors->any() || session('status'))
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        @endif
    });
</script>
</body>
</html>