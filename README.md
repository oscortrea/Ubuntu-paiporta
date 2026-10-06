# PaiportArbolado

> **Despliegue, Infraestructura y Arquitectura Web**

Repositorio oficial para la implementación, configuración y despliegue del sistema de gestión **PaiportArbolado**, desarrollado para el **Ayuntamiento de Paiporta** en el marco del módulo de **Recursos y Servicios en la Nube**.

---

## Especificaciones del Sistema

El proyecto implementa un sistema **CRUD completo** para la administración del censo de arbolado urbano, estructurado bajo un patrón **MVC simplificado** y complementado con una interfaz analítica y endpoints **API REST**.

### Arquitectura Tecnológica

| Componente            | Tecnología                               |
| --------------------- | ---------------------------------------- |
| **Virtualización**    | Oracle VM VirtualBox (Hypervisor Tipo 2) |
| **Sistema Operativo** | Ubuntu Server 26.04 LTS                  |
| **Servidor HTTP**     | Apache 2.4 + `mod_rewrite`               |
| **Base de Datos**     | MariaDB / MySQL                          |
| **Lenguaje**          | PHP 8.x                                  |
| **Extensiones PHP**   | `pdo_mysql`, `gd`, `mbstring`            |
| **Resolución Local**  | `arboles.paiporta.local`                 |

### Funcionalidades y Componentes

* **Gestión CRUD:** Alta, consulta, modificación y baja lógica/física de elementos del censo arbóreo (especie, ubicación, estado fitosanitario, fecha de plantación y recursos gráficos).
* **Filtrado Dinámico:** Motor de búsqueda asíncrono integrado en la vista principal.
* **API REST:** Endpoint dedicado (`/api/arboles.php`) para la serialización de datos en formato JSON.
* **Cuadro de Mando:** Dashboard estadístico interactivo basado en Chart.js.
* **Auditoría:** Sistema de registro persistente de transacciones y eventos en `/logs/`.

---

## Guía de Conectividad y Redes

El acceso al servidor virtualizado desde el host de desarrollo se gestiona mediante un esquema de reenvío de puertos (*Port Forwarding*) sobre interfaz NAT o direccionamiento estático en red privada virtual.

### Conexión por Terminal (SSH)

```bash
ssh usuario@127.0.0.1 -p 2223
```

### Acceso al Servicio Web

Configurar la resolución estática en el archivo de hosts local.

**Linux:**

```text
/etc/hosts
```

**Windows:**

```text
C:\Windows\System32\drivers\etc\hosts
```

Apuntando al dominio:

```text
arboles.paiporta.local
```

---

## Modelo de Seguridad y Control de Accesos

Con el objetivo de cumplir con los estándares de privilegios mínimos en entornos de producción y desarrollo, la estructura de directorios de la aplicación (`/var/www/arboles-paiporta`) disocia la propiedad del código fuente de los procesos del servidor web (`www-data`).

### Propiedad del Código Fuente

El usuario del sistema mantiene el control absoluto sobre los scripts de la aplicación para permitir la gestión del código sin elevación de privilegios:

```bash
sudo chown -R $USER:$USER /var/www/arboles-paiporta

find /var/www/arboles-paiporta -type d -exec chmod 755 {} \;

find /var/www/arboles-paiporta -type f -exec chmod 644 {} \;
```

### Directorios de Escritura Dinámica

Los recursos que requieren persistencia en tiempo de ejecución (subida de imágenes y ficheros de auditoría) se delegan de forma exclusiva al grupo de procesos de Apache:

```bash
sudo mkdir -p /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs

sudo chown -R www-data:www-data /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs

sudo chmod 775 /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
```
