<?php
session_start();
include '../php/admin_cart.php'; // Upewnij się, że ścieżka jest poprawna

// Pobranie szczegółów koszyka
$cartDetails = getCartDetails() ?? [];
$totalValue = getTotalCartValue() ?? 0.00;
?>

<h2>Koszyk</h2>

<?php if (empty($cartDetails)) : ?>
    <p>Twój koszyk jest pusty.</p>
<?php else : ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Cena brutto</th>
                <th>Ilość</th>
                <th>Razem</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartDetails as $productId => $product) : ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= number_format($product['net_price'], 2) ?> zł</td>
                    <td><?= $product['vat'] ?>%</td>
                    <td><?= number_format($product['gross_price'], 2) ?> zł</td>
                    <td>
                        <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" min="1" data-product-id="<?= htmlspecialchars($productId) ?>" class="quantity-input">
                    </td>
                    <td class="total-price" data-product-id="<?= htmlspecialchars($productId) ?>"><?= number_format($product['gross_price'] * $product['quantity'], 2) ?> zł</td>
                    <td>
                        <form method="POST" action="../php/admin_cart.php" style="display: inline;">
                            <input type="hidden" name="productId" value="<?= htmlspecialchars($productId) ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Całkowita wartość:</strong></td>
                <td colspan="2"><strong id="total-cart-value"><?= number_format($totalValue, 2) ?> zł</strong></td>
            </tr>
        </tfoot>
    </table>

    <form method="POST" action="../php/admin_cart.php" style="margin-top: 10px;">
        <input type="hidden" name="action" value="clear">
        <button type="submit">Wyczyść koszyk</button>
    </form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalCartValueElement = document.getElementById('total-cart-value');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value);
            const priceNet = parseFloat(this.closest('tr').querySelector('td:nth-child(2)').innerText);
            const vat = parseFloat(this.closest('tr').querySelector('td:nth-child(3)').innerText) / 100;
            const grossPriceElement = this.closest('tr').querySelector('.total-price');
            
            // Oblicz nową cenę brutto
            const grossPrice = priceNet * (1 + vat) * quantity;
            grossPriceElement.innerText = grossPrice.toFixed(2) + ' zł';
            
            // Zaktualizuj całkowitą wartość koszyka
            let totalCartValue = 0;
            document.querySelectorAll('.total-price').forEach(element => {
                totalCartValue += parseFloat(element.innerText);
            });
            totalCartValueElement.innerText = totalCartValue.toFixed(2) + ' zł';

            // Możesz dodać kod do automatycznego wysyłania żądania AJAX do serwera, aby zaktualizować ilość w koszyku w bazie danych
        });
    });
});
</script>
