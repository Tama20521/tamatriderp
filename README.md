# 🛒 TamaTrix ERP

**Sistema de Gestión Empresarial Inteligente**

Desarrollado por **TamaTechFinance** | Versión 1.0.0 | Septiembre 2026

---

## 📌 Descripción de la Aplicación

**TamaTrix ERP** es un sistema de planificación de recursos empresariales (Enterprise Resource Planning) desarrollado en **Laravel 12** que permite gestionar de forma integral todas las operaciones comerciales de una pequeña o mediana empresa:

- Control de inventario y productos
- Registro de ventas con múltiples productos
- Gestión de clientes y proveedores
- Cuentas por cobrar (ventas a crédito con abonos parciales)
- Cuentas por pagar (compras a crédito con pagos parciales)
- Dashboard financiero con gráficos en tiempo real
- Sistema de roles (Administrador / Vendedor)

El sistema está diseñado con una interfaz moderna, responsiva y fácil de usar, permitiendo a los usuarios gestionar su negocio de manera eficiente desde cualquier dispositivo.

---

## 🎯 Problema o Necesidad que Busca Resolver

Las pequeñas y medianas empresas enfrentan varios desafíos en su gestión diaria:

1. **Falta de control de inventario:** No saber con exactitud qué productos hay disponibles
2. **Pérdida de ventas por descontrol de stock:** Vender productos que ya no existen
3. **Desconocimiento de cuentas pendientes:** No saber quién debe dinero ni a quién se le debe
4. **Falta de información financiera:** No tener visibilidad sobre ingresos, ganancias y tendencias
5. **Registros manuales propensos a errores:** Cuadernos o Excel con datos inconsistentes
6. **Imposibilidad de escalar:** Sistemas manuales que no crecen con el negocio

**TamaTrix ERP** resuelve todos estos problemas en una sola plataforma integrada, automatizando procesos y proporcionando información en tiempo real para la toma de decisiones.

---

## ✨ Funcionalidades Principales

### 🔐 Autenticación y Control de Acceso
- Registro de usuarios con validación
- Login con "Recordarme"
- Recuperación de contraseña
- **Sistema de roles:** Administrador y Vendedor
- Middleware de autorización por rol

### 📊 Dashboard Financiero
- **7 métricas en tiempo real:**
  - Total de ventas (transacciones)
  - Total vendido ($)
  - Total de productos en catálogo
  - Valor del inventario ($)
  - Ventas del día ($)
  - Ticket promedio ($)
  - Productos agotados (con alerta)
- **3 gráficos interactivos con Chart.js:**
  - Ventas por mes
  - Ventas últimos 7 días
  - Stock de productos
- **Top 5 productos más vendidos** con medallas

### 📦 Gestión de Productos (CRUD completo)
- Crear, listar, editar y eliminar productos
- Filtros avanzados: búsqueda por nombre, rango de precios, disponibilidad
- Asignación de proveedor a cada producto
- Indicador visual de stock (verde/amarillo/rojo)
- Paginación de resultados

### 🛒 Punto de Venta
- Selección múltiple de productos (agregar varias líneas)
- Cálculo automático de subtotales y total con JavaScript
- **Tipos de pago:** Contado o Crédito
- Fecha de vencimiento configurable (para crédito)
- Descuento automático de stock al confirmar
- Validación de stock disponible antes de vender
- Transacciones seguras con rollback

### 👥 Gestión de Clientes
- CRUD completo: nombre, email, teléfono, documento, dirección
- Búsqueda por nombre, email, teléfono o documento
- Historial de compras por cliente
- Protección: no se puede eliminar cliente con ventas

### 🏭 Gestión de Proveedores
- CRUD completo con datos de contacto
- Estado activo/inactivo con filtros
- Listado de productos por proveedor
- Cálculo de valor de inventario por proveedor
- Protección: no se puede eliminar proveedor con productos

### 💰 Cuentas por Cobrar
- Listado de ventas a crédito con filtros por estado
- Métricas: total por cobrar, total vencido, facturas pendientes
- Registro de abonos parciales con método de pago
- Historial de abonos por venta
- Estados automáticos: Pendiente / Parcial / Pagado / Vencido

### 📥 Compras a Proveedores
- Registro de compras con múltiples productos
- Costo unitario por línea
- Aumento automático de stock
- Generación automática de cuentas por pagar

### 💸 Cuentas por Pagar
- Listado de compras a crédito con filtros
- Registro de pagos parciales
- Historial de pagos por compra
- Alertas de vencimiento

### 🎨 Diseño Moderno
- Login con gradiente y animaciones
- Navegación con iconos SVG personalizados
- Dashboard con tarjetas de gradiente
- Interfaz 100% responsiva (móvil, tablet, escritorio)