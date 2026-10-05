function buscarArboles() {
    // 1. Obtener el texto del input de búsqueda en minúsculas
    const input = document.getElementById('buscar');
    const filtro = input.value.toLowerCase();
    
    // 2. Obtener todas las filas de la tabla principal
    const filas = document.querySelectorAll('table tr');

    // 3. Recorrer las filas (empezamos en 1 para saltar la cabecera <th>)
    for (let i = 1; i < filas.length; i++) {
        const fila = filas[i];
        const celdas = fila.getElementsByTagName('td');
        
        if (celdas.length > 0) {
            // Según tu index.php:
            // Columna 2 = Especie
            // Columna 3 = Ubicación
            const especie = celdas[2] ? celdas[2].textContent.toLowerCase() : '';
            const ubicacion = celdas[3] ? celdas[3].textContent.toLowerCase() : '';

            // Comprobar si el texto introducido coincide con la especie o la ubicación
            if (especie.includes(filtro) || ubicacion.includes(filtro)) {
                fila.style.display = ''; // Mostrar fila
            } else {
                fila.style.display = 'none'; // Ocultar fila
            }
        }
    }
}// Función de búsqueda dinámica para filtrar los árboles de la tabla en tiempo real
function buscarArboles() {
    // Captura el valor del input y lo pasa a minúsculas
    const input = document.getElementById('buscar').value.toLowerCase();
    
    // Selecciona todas las filas de la tabla omitiendo la cabecera (corregido el selector CSS)
    const rows = document.querySelectorAll('table tr:not(:first-child)');

    rows.forEach(row => {
        // Obtiene todo el texto de la fila y lo pasa a minúsculas
        const text = row.textContent.toLowerCase();
        
        // Muestra u oculta la fila dependiendo de si coincide con la búsqueda
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
