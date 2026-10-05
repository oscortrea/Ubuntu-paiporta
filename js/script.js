// Función de búsqueda dinámica para filtrar los árboles de la tabla en tiempo real
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
