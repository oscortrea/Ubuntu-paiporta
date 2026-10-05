function buscarArboles() {
    const input = document.getElementById('buscar');
    const filtro = input.value.toLowerCase().trim();
    const filas = document.querySelectorAll('table tr');

    // Recorremos las filas (saltando la cabecera i = 1)
    for (let i = 1; i < filas.length; i++) {
        const fila = filas[i];
        
        // Obtenemos todo el texto de la fila completa en minúsculas
        const textoFila = fila.textContent.toLowerCase();

        // Si el texto de la fila incluye lo que hemos escrito en el buscador, se muestra; si no, se oculta
        if (textoFila.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    }
}
