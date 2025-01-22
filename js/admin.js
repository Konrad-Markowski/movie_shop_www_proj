document.getElementById('showCategories').addEventListener('click', function() {
    document.getElementById('categoriesPanel').style.display = 'block';
    document.getElementById('productsPanel').style.display = 'none';
});

document.getElementById('showProducts').addEventListener('click', function() {
    document.getElementById('categoriesPanel').style.display = 'none';
    document.getElementById('productsPanel').style.display = 'block';
});

function handleCategoryFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Wystąpił błąd podczas dodawania kategorii.');
    });

    return false;
}

function handleProductFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Wystąpił błąd podczas dodawania produktu.');
    });

    return false;
}
