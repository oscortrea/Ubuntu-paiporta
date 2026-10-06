# PaiportArbolado

## Despliegue, Infraestructura y Arquitectura Web

Repositorio oficial para la **implementación, configuración y despliegue** de **PaiportArbolado**, un sistema de gestión del censo de arbolado urbano desarrollado para el **Ayuntamiento de Paiporta** en el marco del módulo de **Recursos y Servicios en la Nube**.

---

## 1. Descripción del proyecto

**PaiportArbolado** es una aplicación web destinada a la administración y consulta del censo de arbolado urbano.

El proyecto implementa un sistema **CRUD completo**, siguiendo una arquitectura **MVC simplificada**, complementada con una API REST y un cuadro de mando estadístico para facilitar la consulta y análisis de los datos.

### Funcionalidades principales

* Gestión completa del censo de árboles.
* Alta de nuevos ejemplares.
* Consulta y filtrado dinámico.
* Modificación de registros.
* Baja lógica o física de ejemplares.
* Gestión de imágenes asociadas.
* Dashboard estadístico interactivo.
* API REST con respuestas en formato JSON.
* Sistema de auditoría y registro de eventos.
* Control de permisos sobre los recursos de la aplicación.
* Despliegue sobre servidor Ubuntu.

---

## 2. Arquitectura tecnológica

| Componente          | Tecnología               |
| ------------------- | ------------------------ |
| Virtualización      | Oracle VM VirtualBox     |
| Sistema operativo   | Ubuntu Server 26.04 LTS  |
| Servidor web        | Apache 2.4               |
| Base de datos       | MariaDB / MySQL          |
| Backend             | PHP 8.x                  |
| API                 | REST / JSON              |
| Gráficos            | Chart.js                 |
| Reescritura de URLs | Apache `mod_rewrite`     |
| Dominio local       | `arboles.paiporta.local` |

### Extensiones PHP requeridas

La instalación de PHP debe disponer, como mínimo, de las siguientes extensiones:

```text
pdo_mysql
gd
mbstring
```

---

## 3. Estructura del proyecto

La aplicación se encuentra desplegada en:

```text
/var/www/arboles-paiporta
```

Estructura general:

```text
arboles-paiporta/
├── api/
│   └── arboles.php
├── uploads/
│   └── ...
├── logs/
│   └── ...
├── ...
└── ...
```

Los directorios `uploads/` y `logs/` requieren permisos especiales debido a que Apache necesita escribir en ellos durante la ejecución de la aplicación.

---

## 4. Conectividad y redes

El servidor se ejecuta dentro de una máquina virtual mediante **Oracle VM VirtualBox**.

El acceso desde el equipo anfitrión puede realizarse mediante **NAT con Port Forwarding** o mediante una configuración de red privada con direccionamiento estático.

### 4.1. Acceso mediante SSH

Ejemplo de conexión utilizando un puerto reenviado:

```bash
ssh usuario@127.0.0.1 -p 2223
```

Sustituir `usuario` por el usuario configurado en el servidor Ubuntu.

### 4.2. Acceso web

La aplicación utiliza el dominio local:

```text
arboles.paiporta.local
```

Para resolver este dominio desde el equipo anfitrión es necesario añadir una entrada al archivo `hosts`.

#### Linux

Archivo:

```text
/etc/hosts
```

#### Windows

Archivo:

```text
C:\Windows\System32\drivers\etc\hosts
```

Ejemplo:

```text
127.0.0.1 arboles.paiporta.local
```

La dirección IP utilizada deberá coincidir con la configuración de red empleada por la máquina virtual.

---

## 5. Seguridad y control de accesos

La aplicación sigue un modelo basado en el **principio de mínimo privilegio**.

El código fuente pertenece al usuario encargado de la administración del proyecto, mientras que el proceso de Apache (`www-data`) únicamente dispone de permisos de escritura en los directorios que necesitan ser modificados durante la ejecución.

La aplicación se encuentra en:

```text
/var/www/arboles-paiporta
```

---

## 5.1. Propiedad del código fuente

El código fuente pertenece al usuario del sistema:

```bash
sudo chown -R $USER:$USER /var/www/arboles-paiporta
```

Permisos para los directorios:

```bash
find /var/www/arboles-paiporta -type d -exec chmod 755 {} \;
```

Permisos para los archivos:

```bash
find /var/www/arboles-paiporta -type f -exec chmod 644 {} \;
```

Esta configuración permite mantener separada la administración del código fuente de los procesos ejecutados por el servidor web.

---

## 5.2. Directorios de escritura

Existen determinados recursos que necesitan ser modificados por Apache durante la ejecución de la aplicación:

* `uploads/`: almacenamiento de imágenes.
* `logs/`: registros de auditoría y eventos.

Creación de los directorios:

```bash
sudo mkdir -p /var/www/arboles-paiporta/uploads
sudo mkdir -p /var/www/arboles-paiporta/logs
```

Asignación de propiedad al usuario utilizado por Apache:

```bash
sudo chown -R www-data:www-data \
/var/www/arboles-paiporta/uploads \
/var/www/arboles-paiporta/logs
```

Asignación de permisos:

```bash
sudo chmod 775 /var/www/arboles-paiporta/uploads
sudo chmod 775 /var/www/arboles-paiporta/logs
```

De esta forma, Apache puede escribir únicamente en los directorios necesarios sin disponer de permisos de escritura sobre todo el código fuente.

---

## 6. API REST

El proyecto incorpora una API REST destinada a proporcionar los datos del censo en formato **JSON**.

Endpoint principal:

```text
/api/arboles.php
```

Ejemplo:

```text
http://arboles.paiporta.local/api/arboles.php
```

La API permite que los datos puedan ser consumidos por otros componentes de la aplicación o por clientes externos compatibles con JSON.

---

## 7. Dashboard

PaiportArbolado incorpora un **cuadro de mando estadístico** desarrollado con **Chart.js**.

El dashboard permite representar visualmente información relacionada con el censo, facilitando:

* Análisis estadístico.
* Distribución de especies.
* Información del arbolado urbano.
* Estado fitosanitario.
* Visualización de indicadores.

---

## 8. Filtrado dinámico

La aplicación incorpora un sistema de búsqueda y filtrado dinámico integrado en la vista principal.

Este sistema permite consultar el censo sin necesidad de recargar completamente la página, mejorando la experiencia de usuario y agilizando la consulta de los registros.

---

## 9. Sistema de auditoría

Las operaciones y eventos relevantes de la aplicación pueden registrarse de forma persistente en:

```text
/var/www/arboles-paiporta/logs/
```

Este sistema permite mantener un historial de determinadas operaciones realizadas sobre la aplicación y facilita las tareas de:

* Diagnóstico.
* Mantenimiento.
* Auditoría.
* Seguimiento de operaciones.

---

## 10. Arquitectura de despliegue

El flujo general de despliegue es el siguiente:

```text
┌─────────────────────────┐
│    Equipo anfitrión     │
│       Desarrollo        │
└────────────┬────────────┘
             │
             │ VirtualBox
             ▼
┌─────────────────────────┐
│      Ubuntu Server      │
│        26.04 LTS        │
└────────────┬────────────┘
             │
             ▼
┌─────────────────────────┐
│         Apache          │
│         PHP 8.x         │
└────────────┬────────────┘
             │
       ┌─────┴─────┐
       ▼           ▼
┌────────────┐ ┌──────────────┐
│  MariaDB   │ │ PaiportArbolado │
│  / MySQL   │ │   Aplicación │
└────────────┘ └──────────────┘
```

---

## 11. Requisitos

Para reproducir el entorno de despliegue se requiere:

* Oracle VM VirtualBox.
* Ubuntu Server 26.04 LTS.
* Apache 2.4.
* PHP 8.x.
* MariaDB o MySQL.
* Extensión `pdo_mysql`.
* Extensión `gd`.
* Extensión `mbstring`.
* Apache `mod_rewrite`.
* Acceso SSH.
* Configuración del dominio local `arboles.paiporta.local`.

---

## 12. Proyecto

**PaiportArbolado**

Sistema de gestión del censo de arbolado urbano para el **Ayuntamiento de Paiporta**.

Proyecto académico desarrollado dentro del módulo de **Recursos y Servicios en la Nube**.
PaiportArbolado: Despliegue, Infraestructura y Arquitectura Web

Repositorio oficial para la implementación, configuración y despliegue del sistema de gestión PaiportArbolado, desarrollado para el Ayuntamiento de Paiporta en el marco del módulo de Recursos y Servicios en la Nube.
1. Especificaciones del Sistema

El proyecto implementa un sistema CRUD completo para la administración del censo de arbolado urbano, estructurado bajo un patrón MVC simplificado y complementado con una interfaz analítica y endpoints API REST.
Arquitectura Tecnológica

    Virtualización: Oracle VM VirtualBox (Hypervisor Tipo 2).

    Sistema Operativo: Ubuntu Server 26.04 LTS.

    Servidor HTTP: Apache 2.4 con módulo mod_rewrite habilitado.

    Base de Datos: MariaDB / MySQL.

    Lenguaje: PHP 8.x (extensiones requeridas: pdo_mysql, gd, mbstring).

    Resolución Local: arboles.paiporta.local

Funcionalidades y Componentes

    Gestión CRUD: Alta, consulta, modificación y baja lógica/física de elementos del censo arbóreo (especie, ubicación, estado fitosanitario, fecha de plantación y recursos gráficos).

    Filtrado Dinámico: Motor de búsqueda asíncrono integrado en la vista principal.

    API REST: Endpoint dedicado (/api/arboles.php) para la serialización de datos en formato JSON.

    Cuadro de Mando: Dashboard estadístico interactivo basado en Chart.js.

    Auditoría: Sistema de registro persistente de transacciones y eventos en /logs/.

2. Guía de Conectividad y Redes

El acceso al servidor virtualizado desde el host de desarrollo se gestiona mediante un esquema de reenvío de puertos (Port Forwarding) sobre interfaz NAT o direccionamiento estático en red privada virtual.

    Conexión por Terminal (SSH):
    Bash

    ssh usuario@127.0.0.1 -p 2223

    Acceso al Servicio Web:
    Configurar la resolución estática en el archivo de hosts local (/etc/hosts o C:\Windows\System32\drivers\etc\hosts) apuntando al dominio arboles.paiporta.local.

3. Modelo de Seguridad y Control de Accesos

Con el objetivo de cumplir con los estándares de privilegios mínimos en entornos de producción y desarrollo, la estructura de directorios de la aplicación (/var/www/arboles-paiporta) disocia la propiedad del código fuente de los procesos del servidor web (www-data).
3.1. Propiedad del Código Fuente

El usuario del sistema mantiene el control absoluto sobre los scripts de la aplicación para permitir la gestión del código sin elevación de privilegios:
Bash

sudo chown -R $USER:$USER /var/www/arboles-paiporta
find /var/www/arboles-paiporta -type d -exec chmod 755 {} \;
find /var/www/arboles-paiporta -type f -exec chmod 644 {} \;

3.2. Directorios de Escritura Dinámica

Los recursos que requieren persistencia en tiempo de ejecución (subida de imágenes y ficheros de auditoría) se delegan de forma exclusiva al grupo de procesos de Apache:
Bash

sudo mkdir -p /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
sudo chown -R www-data:www-data /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
sudo chmod 775 /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logsPaiportArbolado: Despliegue, Infraestructura y Arquitectura Web

Repositorio oficial para la implementación, configuración y despliegue del sistema de gestión PaiportArbolado, desarrollado para el Ayuntamiento de Paiporta en el marco del módulo de Recursos y Servicios en la Nube.
1. Especificaciones del Sistema

El proyecto implementa un sistema CRUD completo para la administración del censo de arbolado urbano, estructurado bajo un patrón MVC simplificado y complementado con una interfaz analítica y endpoints API REST.
Arquitectura Tecnológica

    Virtualización: Oracle VM VirtualBox (Hypervisor Tipo 2).

    Sistema Operativo: Ubuntu Server 26.04 LTS.

    Servidor HTTP: Apache 2.4 con módulo mod_rewrite habilitado.

    Base de Datos: MariaDB / MySQL.

    Lenguaje: PHP 8.x (extensiones requeridas: pdo_mysql, gd, mbstring).

    Resolución Local: arboles.paiporta.local

Funcionalidades y Componentes

    Gestión CRUD: Alta, consulta, modificación y baja lógica/física de elementos del censo arbóreo (especie, ubicación, estado fitosanitario, fecha de plantación y recursos gráficos).

    Filtrado Dinámico: Motor de búsqueda asíncrono integrado en la vista principal.

    API REST: Endpoint dedicado (/api/arboles.php) para la serialización de datos en formato JSON.

    Cuadro de Mando: Dashboard estadístico interactivo basado en Chart.js.

    Auditoría: Sistema de registro persistente de transacciones y eventos en /logs/.

2. Guía de Conectividad y Redes

El acceso al servidor virtualizado desde el host de desarrollo se gestiona mediante un esquema de reenvío de puertos (Port Forwarding) sobre interfaz NAT o direccionamiento estático en red privada virtual.

    Conexión por Terminal (SSH):
    ssh usuario@127.0.0.1 -p 2223

    Acceso al Servicio Web:
    Configurar la resolución estática en el archivo de hosts local (/etc/hosts o C:\Windows\System32\drivers\etc\hosts) apuntando al dominio arboles.paiporta.local.

3. Modelo de Seguridad y Control de Accesos

Con el objetivo de cumplir con los estándares de privilegios mínimos en entornos de producción y desarrollo, la estructura de directorios de la aplicación (/var/www/arboles-paiporta) disocia la propiedad del código fuente de los procesos del servidor web (www-data).
3.1. Propiedad del Código Fuente

El usuario del sistema mantiene el control absoluto sobre los scripts de la aplicación para permitir la gestión del código sin elevación de privilegios:

sudo chown -R $USER:$USER /var/www/arboles-paiporta
find /var/www/arboles-paiporta -type d -exec chmod 755 {} ;
find /var/www/arboles-paiporta -type f -exec chmod 644 {} ;
3.2. Directorios de Escritura Dinámica

Los recursos que requieren persistencia en tiempo de ejecución (subida de imágenes y ficheros de auditoría) se delegan de forma exclusiva al grupo de procesos de Apache:

sudo mkdir -p /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
sudo chown -R www-data:www-data /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
sudo chmod 775 /var/www/arboles-paiporta/uploads /var/www/arboles-paiporta/logs
