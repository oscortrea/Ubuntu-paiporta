function searchTrees() {
    const input = document.getElementById('buscar').value.toLowerCase();
    const rows = document.querySelectorAll('table tr\:not(\:first-child)');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
