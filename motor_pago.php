<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Motor de Pago - Botica</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-bl from-[#505b96] to-[#1d2332] min-h-screen p-6 font-sans">

  <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 space-y-6">
    <!-- Encabezado -->
    <div class="flex justify-between items-center border-b pb-4">
      <h2 class="text-2xl font-bold text-gray-800">Motor de Pago</h2>
      <div class="text-right text-gray-600">
        <p><span class="font-semibold">Transacción:</span> #000123</p>
        <p><span class="font-semibold">Fecha:</span> 21/06/2025</p>
        <p><span class="font-semibold">Cajero:</span> María Pérez</p>
      </div>
    </div>

    <!-- Tabla de productos -->
    <div>
      <table class="w-full text-left border">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2">Producto</th>
            <th class="p-2 text-center">Cantidad</th>
            <th class="p-2 text-right">Precio Unitario</th>
            <th class="p-2 text-right">Subtotal</th>
            <th class="p-2 text-center">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-t">
            <td class="p-2">Paracetamol 500mg</td>
            <td class="p-2 text-center">2</td>
            <td class="p-2 text-right">S/ 2.50</td>
            <td class="p-2 text-right">S/ 5.00</td>
            <td class="p-2 text-center"><button class="text-red-500 hover:underline">Eliminar</button></td>
          </tr>
          <tr class="border-t">
            <td class="p-2">Alcohol 70%</td>
            <td class="p-2 text-center">1</td>
            <td class="p-2 text-right">S/ 3.00</td>
            <td class="p-2 text-right">S/ 3.00</td>
            <td class="p-2 text-center"><button class="text-red-500 hover:underline">Eliminar</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Totales -->
    <div class="flex justify-end space-y-1 text-right">
      <div class="w-1/2 space-y-1">
        <div class="flex justify-between">
          <span>Subtotal:</span>
          <span>S/ 8.00</span>
        </div>
        <div class="flex justify-between">
          <span>IGV (18%):</span>
          <span>S/ 1.44</span>
        </div>
        <div class="flex justify-between font-bold text-lg">
          <span>Total a Pagar:</span>
          <span>S/ 9.44</span>
        </div>
      </div>
    </div>

    <!-- Método de pago -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-1 font-semibold">Método de Pago</label>
        <select class="w-full border rounded px-3 py-2">
          <option>Efectivo</option>
          <option>Tarjeta</option>
          <option>Yape</option>
          <option>Transferencia</option>
          <option>Mixto</option>
        </select>
      </div>
      <div>
        <label class="block mb-1 font-semibold">Monto Recibido</label>
        <input type="number" placeholder="S/ 10.00" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-semibold">Vuelto</label>
        <input type="text" value="S/ 0.56" disabled class="w-full border rounded px-3 py-2 bg-gray-100">
      </div>
    </div>

    <!-- Datos del cliente -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div>
        <label class="block mb-1 font-semibold">Nombre del Cliente</label>
        <input type="text" placeholder="Juan Torres" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-semibold">DNI / RUC</label>
        <input type="text" placeholder="12345678" class="w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block mb-1 font-semibold">Email</label>
        <input type="email" placeholder="correo@ejemplo.com" class="w-full border rounded px-3 py-2">
      </div>
    </div>

    <!-- Botones -->
    <div class="flex justify-end space-x-4 pt-6 border-t pt-4">
      <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded">Cancelar</button>
      <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">Emitir Boleta</button>
      <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">Imprimir</button>
    </div>

  </div>

</body>
</html>
