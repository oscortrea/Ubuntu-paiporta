PaiportArbolado - Despliegue e Infraestructura en la Nube

Este repositorio contiene la solución completa para el despliegue, configuración y resolución de problemas de la aplicación web PaiportArbolado, desarrollada para el Ayuntamiento de Paiporta dentro del módulo de Recursos y Servicios en la Nube.

📌 Descripción del Proyecto

El objetivo de este trabajo es recuperar una aplicación web en PHP inconclusa y ponerla en marcha en un entorno de servidor sobre infraestructura de virtualización (Hypervisor VirtualBox). La aplicación consiste en un sistema de gestión CRUD para el censo de árboles del municipio.

Funcionalidades Integradas:

Create: Añadir nuevas entradas de árboles (especie, ubicación, estado, fecha e imagen).

Read: Listar los árboles registrados en la base de datos mediante tabla interactiva.

Update: Editar la información técnica de cualquier árbol registrado.

Delete: Eliminar registros del censo tras previa confirmación.

Búsqueda/Filtros: Filtrado dinámico por especie o ubicación.

Logs de Auditoría: Registro persistente de acciones en /logs/acciones.log.

Subida de Archivos: Gestión de imágenes de árboles almacenadas en ./uploads/.

Dashboard Estadístico: Gráficos dinámicos con Chart.js consumidos desde una API REST interna.

🏗️ Arquitectura de la Infraestructura

Hypervisor: Oracle VM VirtualBox

Sistema Operativo: Ubuntu Server 26.04 LTS

Servidor Web: Apache2 (con módulo rewrite activado)

Base de Datos: MariaDB / MySQL

Lenguaje de Programación: PHP 8.x (con extensiones pdo_mysql)

Dominio Local (DNS): arboles.paiporta.local
