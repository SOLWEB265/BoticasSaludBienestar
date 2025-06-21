<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documentos - Botica</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen">
<div class="w-full flex flex-col items-end ">
    <div class="flex justify-center items-center gap-3 p-4">      
      <a href="interfaz.php" class="flex justify-center pr-2 items-center">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
          </button>
        </a>
      <span class="text-lg font-medium text-white">Botica salud y bienestar</span>
      <div class="relative flex justify-center items-center">
          <button onclick="toggleLogoutMenu(event)">
            <img src="imagenes/User.jpg" class="w-6 h-6 cursor-pointer rounded-full" alt="Salir Icon">
          </button>
          <div id="logoutMenu" class="hidden absolute right-0 top-8 w-40 bg-white rounded-md shadow-lg z-10">
            <a href="?logout=true" class="block px-4 py-2 rounded-md text-gray-800 hover:bg-gray-100">Cerrar sesión</a>
          </div>
        </div>
    </div>
</div>
    <div class="max-w-7xl mx-auto p-6">
      <!-- Encabezado -->
      <div class="bg-gradient-to-r from-violet-600 to-purple-500 text-white p-6 rounded-t-xl">
        <h1 class="text-3xl font-bold flex items-center gap-2">
          <span>📄</span>
          Documentos
        </h1>
        <p class="text-sm">Botica Salud y Bienestar - Gestión de Documentos</p>
      </div>
    
      <!-- Barra de búsqueda y filtros -->
      <div class="bg-white p-4 rounded-b-xl shadow-md flex flex-wrap gap-4 items-center justify-between">
        <input type="text" placeholder="Buscar documentos..." class="flex-1 border border-gray-300 rounded px-4 py-2" />
    
        <div class="flex gap-4">
          <select class="border border-gray-300 rounded px-3 py-2">
            <option>Todos los tipos</option>
            <option>Facturación</option>
            <option>Farmacia</option>
            <option>Inventario</option>
            <option>Reportes</option>
          </select>
    
          <select class="border border-gray-300 rounded px-3 py-2">
            <option>Último mes</option>
            <option>Este mes</option>
            <option>Este año</option>
            <option>Todos</option>
          </select>
        </div>
      </div>
    
      <!-- Tarjetas de secciones -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Facturación -->
        <div class="bg-white p-5 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold flex items-center gap-2 text-purple-700">
            <span class="bg-purple-100 p-2 rounded"><svg class="w-5 h-5 text-purple-700" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v1h16V5a2 2 0 00-2-2H4zM2 9h16v8a2 2 0 01-2 2H4a2 2 0 01-2-2V9zm4 2a1 1 0 000 2h8a1 1 0 100-2H6z" /></svg></span>
            Facturación
          </h2>
          <ul class="mt-4 space-y-2">
            <li class="flex justify-between border-b pb-1">Facturas emitidas <span class="bg-purple-600 text-white rounded-full px-2">245</span></li>
            <li class="flex justify-between border-b pb-1">Facturas pendientes <span class="bg-purple-600 text-white rounded-full px-2">12</span></li>
            <li class="flex justify-between border-b pb-1">Notas de crédito <span class="bg-purple-600 text-white rounded-full px-2">8</span></li>
            <li class="flex justify-between border-b pb-1">Boletas de venta <span class="bg-purple-600 text-white rounded-full px-2">567</span></li>
          </ul>
        </div>
    
        <!-- Farmacia -->
        <div class="bg-white p-5 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold flex items-center gap-2 text-pink-700">
            <span class="bg-pink-100 p-2 rounded">🌿</span>
            Farmacia
          </h2>
          <ul class="mt-4 space-y-2">
            <li class="flex justify-between border-b pb-1">Recetas médicas <span class="bg-pink-600 text-white rounded-full px-2">189</span></li>
            <li class="flex justify-between border-b pb-1">Órdenes de compra <span class="bg-pink-600 text-white rounded-full px-2">34</span></li>
            <li class="flex justify-between border-b pb-1">Certificados sanitarios <span class="bg-pink-600 text-white rounded-full px-2">23</span></li>
            <li class="flex justify-between border-b pb-1">Protocolos de calidad <span class="bg-pink-600 text-white rounded-full px-2">15</span></li>
          </ul>
        </div>
    
        <!-- Inventario -->
        <div class="bg-white p-5 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold flex items-center gap-2 text-yellow-700">
            <span class="bg-yellow-100 p-2 rounded">📦</span>
            Inventario
          </h2>
          <ul class="mt-4 space-y-2">
            <li class="flex justify-between border-b pb-1">Control de stock <span class="bg-yellow-600 text-white rounded-full px-2">78</span></li>
            <li class="flex justify-between border-b pb-1">Ingresos de mercadería <span class="bg-yellow-600 text-white rounded-full px-2">45</span></li>
            <li class="flex justify-between border-b pb-1">Bajas por vencimiento <span class="bg-yellow-600 text-white rounded-full px-2">6</span></li>
            <li class="flex justify-between border-b pb-1">Inventarios físicos <span class="bg-yellow-600 text-white rounded-full px-2">4</span></li>
          </ul>
        </div>
    
        <!-- Reportes -->
        <div class="bg-white p-5 rounded-lg shadow-md">
          <h2 class="text-lg font-semibold flex items-center gap-2 text-indigo-700">
            <span class="bg-indigo-100 p-2 rounded">📊</span>
            Reportes
          </h2>
          <ul class="mt-4 space-y-2">
            <li class="flex justify-between border-b pb-1">Reportes de ventas <span class="bg-indigo-600 text-white rounded-full px-2">31</span></li>
            <li class="flex justify-between border-b pb-1">Estados financieros <span class="bg-indigo-600 text-white rounded-full px-2">12</span></li>
            <li class="flex justify-between border-b pb-1">Análisis de productos <span class="bg-indigo-600 text-white rounded-full px-2">18</span></li>
            <li class="flex justify-between border-b pb-1">Reportes tributarios <span class="bg-indigo-600 text-white rounded-full px-2">9</span></li>
          </ul>
        </div>
      </div>
    </div>

</body>

</html>
