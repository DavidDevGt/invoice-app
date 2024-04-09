# InvoiceApp

1. **Autenticación de Usuarios**:
   - Los usuarios deben poder iniciar sesión utilizando su usuario y contraseña.
   - Deben existir roles de usuario (por ejemplo, administrador, contador, vendedor) con diferentes niveles de acceso a las funciones de la aplicación.

2. **Gestión de Roles y Permisos**:
   - Los administradores deben poder crear, actualizar y eliminar roles de usuario.
   - Los roles deben tener permisos asociados para acceder a diferentes partes de la aplicación (por ejemplo, crear facturas, gestionar clientes, ver informes fiscales).

3. **Gestión de Clientes**:
   - Debe ser posible agregar, ver, actualizar y eliminar clientes.
   - Los clientes deben tener información como nombre, dirección, NIT, correo electrónico, etc.

4. **Gestión de Pedidos y Facturas**:
   - Debe ser posible crear nuevos pedidos para clientes.
   - Los pedidos deben contener información detallada sobre los artículos comprados, cantidades, precios unitarios, etc.
   - Los pedidos deben poder convertirse en facturas una vez que se completen.
   - Debe ser posible generar facturas basadas en los pedidos y enviarlas a los clientes.
   - Las facturas deben contener información sobre los artículos vendidos, cantidades, precios, campos obligatorios de la SAT (Superintendencia de Administración Tributaria), como el NIT del cliente, el número de factura, serie, fecha de emisión, etc.

5. **Gestión de Inventario**:
   - Debe ser posible agregar, ver, actualizar y eliminar artículos del inventario.
   - Los artículos deben tener información como nombre, descripción, precio de venta, precio de compra, existencias en inventario, etc.

6. **Registro de Movimientos de Inventario**:
   - Debe haber un registro de todos los movimientos de inventario, como ingresos de mercadería, ventas, devoluciones, ajustes de inventario, etc.
   - Cada movimiento de inventario debe estar asociado con el usuario que lo realizó y la fecha en que ocurrió.

## Pantallas o Vistas de la App

1. **Pantalla de inicio / Inicio de Sesión:**
   - Una pantalla simple donde el usuario puede ingresar sus credenciales (usuario y contraseña) para acceder a la aplicación.

2. **Dashboard o Panel de Control:**
   - Una pantalla central desde donde el usuario puede acceder a las principales funcionalidades de la aplicación de manera rápida y fácil. Aquí, el usuario puede ver:
     - Lista de clientes.
     - Pedidos recientes.
     - Vista de calendario con fechas de pedidos programados.
     - Acceso a otras funciones importantes de la aplicación, como la gestión de clientes, pedidos, facturas, etc.
     - La posibilidad de iniciar un nuevo pedido de manera intuitiva.

3. **Vista de Pedido y POS (Punto de Venta):**
   - En esta vista, el usuario tendrá la capacidad de realizar todas las acciones necesarias para gestionar un pedido de manera fluida y eficiente. Aquí se incluyen:
     - **Barra de búsqueda de productos:** Permite al usuario buscar productos por nombre o código de barras.
     - **Lista de productos disponibles:** Muestra los productos disponibles para agregar al pedido, con detalles como nombre, precio unitario y cantidad en stock.
     - **Formulario de cliente:** Permite al usuario agregar o seleccionar un cliente para el pedido, con campos como nombre, dirección y contacto.
     - **Tabla de líneas de pedido:** Muestra los productos agregados al pedido, con detalles como nombre del producto, cantidad, precio unitario y total por línea.
     - **Opciones de edición:** Botones o campos de entrada que permiten al usuario editar la cantidad de productos, eliminar líneas de pedido o ajustar el precio de los productos (sin reducir el precio por debajo del establecido en la base de datos).
     - **Botones de acción:** Permiten al usuario guardar el pedido, cancelarlo o realizar otras acciones relevantes, como imprimir la factura o procesar el pago.
     - **Resumen del pedido:** Muestra un resumen del pedido actual, incluyendo el total de productos, el total a pagar y cualquier otra información relevante.

- Ultima Actualizacion: 09-04-2024 5:00 AM
