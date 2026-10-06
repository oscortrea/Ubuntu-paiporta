# PaiportArbolado: Despliegue, Infraestructura y Arquitectura Web

Repositorio oficial para la implementación, configuración y despliegue del sistema de gestión **PaiportArbolado**, desarrollado para el Ayuntamiento de Paiporta en el marco del módulo de Recursos y Servicios en la Nube.

---

## 1. Especificaciones del Sistema

El proyecto implementa un sistema CRUD completo para la administración del censo de arbolado urbano, estructurado bajo un patrón MVC simplificado y complementado con una interfaz analítica y endpoints API REST.

### Arquitectura Tecnológica
* **Virtualización:** Oracle VM VirtualBox (Hypervisor Tipo 2).
* **Sistema Operativo:** Ubuntu Server 26.04 LTS.
* **Servidor HTTP:** Apache 2.4 con módulo `mod_rewrite` habilitado.
* **Base de Datos:** MariaDB / MySQL.
* **Lenguaje:** PHP 8.x (extensiones requeridas: `pdo_mysql`, `gd`, `mbstring`).
* **Resolución Local:** `arboles.paiporta.local`

### Funcionalidades y Componentes
* **Gestión CRUD:** Alta, consulta, modificación y baja lógica/física de elementos del censo arbóreo (especie, ubicación, estado fitosanitario, fecha de plantación y recursos gráficos).
* **Filtrado Dinámico:** Motor de búsqueda asíncrono integrado en la vista principal.
* **API REST:** Endpoint dedicado (`/api/arboles.php`) para la serialización de datos en formato JSON.
* **Cuadro de Mando:** Dashboard estadístico interactivo basado en Chart.js.
* **Auditoría:** Sistema de registro persistente de transacciones y eventos en `/logs/`.

---

## 2. Guía de Conectividad y Redes

El acceso al servidor virtualizado desde el host de desarrollo se gestiona mediante un esquema de reenvío de puertos (*Port Forwarding*) sobre interfaz NAT o direccionamiento estático en red privada virtual.

* **Conexión por Terminal (SSH):**
  ```bash
  ssh usuario@localhost -p 2222
