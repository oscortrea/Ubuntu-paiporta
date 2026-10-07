// Definición de diapositivas mediante el DSL de SlideJS
slides {
  slide {
    title: "PaiportArbolado: Despliegue, Infraestructura y Arquitectura Web"
    content: "Ayuntamiento de Paiporta — Módulo de Recursos y Servicios en la Nube"
  }

  slide {
    title: "1. Especificaciones del Sistema"
    bullets: [
      "Virtualización: Oracle VM VirtualBox (Hypervisor Tipo 2)",
      "Sistema Operativo: Ubuntu Server 26.04 LTS",
      "Servidor HTTP: Apache 2.4 con módulo mod_rewrite",
      "Base de Datos: MariaDB / MySQL",
      "Runtime: PHP 8.x (pdo_mysql, gd, mbstring)",
      "Dominio Local: arboles.paiporta.local"
    ]
  }

  slide {
    title: "2. Componentes y Funcionalidades"
    bullets: [
      "Gestión CRUD: Alta, consulta, modificación y baja de elementos arbóreos.",
      "Filtrado Dinámico: Motor de búsqueda asíncrono integrado.",
      "API REST: Endpoint dedicado (/api/arboles.php) para serialización JSON.",
      "Cuadro de Mando: Dashboard estadístico interactivo con Chart.js.",
      "Auditoría: Registro persistente de transacciones en /logs/."
    ]
  }

  slide {
    title: "3. Guía de Conectividad y Redes"
    content: "Acceso al servidor virtualizado mediante reenvío de puertos (Port Forwarding)."
    code: "ssh usuario@127.0.0.1 -p 2223"
  }

  slide {
    title: "4. Modelo de Seguridad y Permisos"
    content: "Disociación de privilegios entre el código del desarrollador y Apache."
    code: "sudo chown -R $USER:$USER /var/www/arboles-paiporta\nsudo chown -R www-data:www-data /var/www/arboles-paiporta/uploads"
  }
}
