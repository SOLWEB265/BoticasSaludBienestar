<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Recientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-100 p-[3.5rem] bg-gradient-to-bl from-[#505b96] to-[#1d2332]">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div>            
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ventas Recientes</h1>
        <div class="flex justify-end items-end">
            <div class="relative ">
                <input type="text" placeholder="Buscar ventas..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        </div>
        <div class="mt-6 border-t pt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Juan Pérez</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/06/2025 10:30</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 145.50</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Carla Mendoza</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/06/2025 10:15</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 89.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Lucía Ramírez</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/06/2025 09:45</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 267.80</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Pedro Castillo</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/06/2025 09:20</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 45.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Ana Torres</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">20/06/2025 08:55</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 198.30</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Mario Quiroz</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">19/06/2025 18:30</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 112.50</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Silvia Rios</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">19/06/2025 17:45</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 76.20</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completada</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">Raúl Gutiérrez</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">19/06/2025 16:20</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">S/ 203.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>        
        
    </div>
</body>
</html>