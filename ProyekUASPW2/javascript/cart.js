let selectedItems = {};

// Load awal
window.onload = () => {
    loadCartFromServer();
};

// Menempelkan event listeners ke button "Add to Cart" 
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const price = parseFloat(button.getAttribute('data-price'));

        if (selectedItems[id]) {
            selectedItems[id].count += 1;
        } else {
            selectedItems[id] = { id, name, price, count: 1 };
        }

        syncCartWithServer();
    });
});

// Perbarui UI cart
function updateCartDisplayOnly() {
    const cartList = document.getElementById('cart');
    if (!cartList) return;

    cartList.innerHTML = '';
    let total = 0;

    for (const itemId in selectedItems) {
        const item = selectedItems[itemId];

        // membuat list item yang dibeli
        const listItem = document.createElement('li');
        const quantityContainer = document.createElement('div');
        quantityContainer.style.display = 'flex';
        quantityContainer.style.alignItems = 'center';
        quantityContainer.style.gap = '8px';
        quantityContainer.style.marginTop = '5px';

        // jumlah barang tertentu yang dibeli
        const quantityText = document.createElement('span');
        quantityText.className = 'quantity-text';
        quantityText.textContent = item.count;

        // menambah jumlah barang tertentu
        const addButton = document.createElement('button');
        addButton.className = 'add-btn';
        addButton.innerHTML = '<i class="fas fa-plus"></i>';
        addButton.addEventListener('click', () => {
            addItem(itemId);
        });
        
        // mengurangi jumlah barang tertentu
        const subtractButton = document.createElement('button');
        subtractButton.className = 'subtract-btn';
        subtractButton.innerHTML = '<i class="fas fa-minus"></i>';
        subtractButton.addEventListener('click', () => {
            removeItem(itemId);
        });

        // menambahkan elemen ke UI
        quantityContainer.appendChild(subtractButton);
        quantityContainer.appendChild(quantityText);
        quantityContainer.appendChild(addButton);

        const hr = document.createElement('hr');

        listItem.innerHTML = `${item.name} - $${(item.price * item.count).toFixed(2)}`;
        listItem.appendChild(document.createElement('br'));
        listItem.appendChild(quantityContainer);
        listItem.appendChild(hr);

        // menaruh list barang di UI
        cartList.appendChild(listItem);

        // total harga item
        total += item.price * item.count;
    }
    
    // menunjukkan total harga item
    const totalElem = document.getElementById('total');
    if (totalElem) {
        totalElem.textContent = `Total Amount: $${total.toFixed(2)}`;
    }
}

// Tambahkan item ke keranjang dan sync
function addItem(id) {
    if (selectedItems[id]) {
        selectedItems[id].count += 1;
        syncCartWithServer();
    }
}

// Mengurangi jumlah or menghapus sebuah item
function removeItem(id) {
    if (selectedItems[id]) {
        selectedItems[id].count -= 1;
        if (selectedItems[id].count <= 0) {
            // Menghapus item dari server-side cart
            fetch('update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ remove: id })
            }).then(() => loadCartFromServer());
            return;
        }
        syncCartWithServer();
    }
}

// Sync seluruh cart dengan server
function syncCartWithServer() {
    fetch('update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(Object.values(selectedItems))
    }).then(() => loadCartFromServer());
}

// Load cart dari server
function loadCartFromServer() {
    fetch('get_cart.php')
        .then(res => res.json())
        .then(data => {
            selectedItems = {};
            data.forEach(item => {
                selectedItems[item.id] = item;
            });
            updateCartDisplayOnly();
        });
}
