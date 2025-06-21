<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ventas Recientes</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gradient-to-bl w-full from-[#505b96] to-[#1d2332] min-h-screen  flex flex-col  ">
    <div class="w-full flex flex-col items-end ">
    <div class="flex justify-center items-center gap-3 p-4">      
      <a href="interfaz.php">
          <button>
            <img src="imagenes/Retroceder.png" alt="Retroceder" class="w-5 h-5 ">
          </button>
        </a>
      <span class="text-lg font-medium text-white">Botica salud y bienestar</span>
      <img src="imagenes/User.jpg" class="w-10 h-10 rounded-full" alt="User  Image">
    </div>
  </div>
<div class="p-12 w-full flex items-center justify-center">
      <div class="bg-white w-full max-w-3xl rounded-lg shadow-lg overflow-hidden p-6">
        <div class="flex items-center justify-between px-6 py-4 border-b">
          <h2 class="text-xl font-semibold flex items-center gap-2">
            <span class="text-red-500">📄</span> Ventas Recientes
          </h2>
          <div class="relative">
            <input type="text" placeholder="Buscar ventas..." class="border rounded-full pl-4 pr-10 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-300">
            <span class="absolute right-3 top-1.5 text-gray-500">🔍</span>
          </div>
        </div>
    
        <table class="w-full text-sm text-left">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 font-medium">Cliente</th>
              <th class="px-6 py-3 font-medium">Fecha</th>
              <th class="px-6 py-3 font-medium">Total</th>
              <th class="px-6 py-3 font-medium">Estado</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Juan Pérez</td>
              <td class="px-6 py-3">20/06/2025 10:30</td>
              <td class="px-6 py-3 font-semibold">S/ 145.50</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Carla Mendoza</td>
              <td class="px-6 py-3">20/06/2025 10:15</td>
              <td class="px-6 py-3 font-semibold">S/ 89.00</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Lucía Ramírez</td>
              <td class="px-6 py-3">20/06/2025 09:45</td>
              <td class="px-6 py-3 font-semibold">S/ 267.80</td>
              <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Pendiente</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Pedro Castillo</td>
              <td class="px-6 py-3">20/06/2025 09:20</td>
              <td class="px-6 py-3 font-semibold">S/ 45.00</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Ana Torres</td>
              <td class="px-6 py-3">20/06/2025 08:55</td>
              <td class="px-6 py-3 font-semibold">S/ 198.30</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Mario Quiroz</td>
              <td class="px-6 py-3">19/06/2025 18:30</td>
              <td class="px-6 py-3 font-semibold">S/ 112.50</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr class="border-b">
              <td class="px-6 py-3 font-semibold">Silvia Ríos</td>
              <td class="px-6 py-3">19/06/2025 17:45</td>
              <td class="px-6 py-3 font-semibold">S/ 76.20</td>
              <td class="px-6 py-3"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Completada</span></td>
            </tr>
            <tr>
              <td class="px-6 py-3 font-semibold">Raúl Gutiérrez</td>
              <td class="px-6 py-3">19/06/2025 16:20</td>
              <td class="px-6 py-3 font-semibold">S/ 203.00</td>
              <td class="px-6 py-3"><span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">Pendiente</span></td>
            </tr>
          </tbody>
        </table>
      </div>
</div>
</body>

</html>
