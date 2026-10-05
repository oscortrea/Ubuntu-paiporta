function buscarArboles() {
    const input = document.getElementById('buscar');
    const filtro = input.value.toLowerCase().trim();
    const tabla = document.getElementById('tabla-arboles');
    const filas = tabla.getElementsByTagName('tr');

    for (let i = 1; i < filas.length; i++) {
        const fila = filas[i];
        const textoFila = fila.textContent.toLowerCase();

        if (textoFila.includes(filtro)) {
            fila.style.display = '';
        } else {
            fila.style.display = 'none';
        }
    }
}
