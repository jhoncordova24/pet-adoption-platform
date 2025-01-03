document.addEventListener('DOMContentLoaded', function() {
    // Escuchar cambios en los checkboxes de ambos conjuntos de filtros
    document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', syncCheckboxes);
    });

    // Aplicar filtros al cargar la página para mostrar resultados iniciales
    applyFilters();
});

function syncCheckboxes(event) {
    const checkbox = event.target;
    const name = checkbox.name;
    const value = checkbox.value;
    const isChecked = checkbox.checked;

    // Sincronizar checkbox en el otro formulario
    const otherCheckboxes = document.querySelectorAll(`.filter-checkbox[name="${name}"][value="${value}"]`);
    otherCheckboxes.forEach(otherCheckbox => {
        if (otherCheckbox !== checkbox) {
            otherCheckbox.checked = isChecked;
        }
    });

    applyFilters();
}

function toggleSubMenu(id) {
    const submenu = document.getElementById(id);
    const symbol = document.getElementById(`toggle-symbol-${id}`);
    if (submenu.style.display === 'block') {
        submenu.style.display = 'none';
        symbol.textContent = '+';
    } else {
        submenu.style.display = 'block';
        symbol.textContent = '-';
    }
}

function applyFilters() {
    const formData = new FormData(document.getElementById('filtros-form'));
    const params = new URLSearchParams(formData);

    fetch('filtros.php?' + params.toString())
        .then(response => response.text())
        .then(data => {
            document.querySelector('.posts').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}

function limpiarFiltros() {
    document.getElementById('filtros-form').reset(); // Esto restablece todos los valores del formulario
    applyFilters(); // Aplicar filtros después de limpiar
}

function toggleMenu() {
    const menu = document.getElementById('menu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
}
