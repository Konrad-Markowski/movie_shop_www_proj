<?php
include '../php/admin_cart.php'; // Upewnij się, że ścieżka jest poprawna

// Pobranie szczegółów koszyka
$cartDetails = getCartDetails() ?? [];
$totalValue = getTotalCartValue() ?? 0.00;
?>

<h2>Koszyk</h2>

<?php if (empty($cartDetails)) : ?>
    <p>Twój koszyk jest pusty.</p>
<?php else : ?>
    <form method="POST" action="../php/admin_cart.php">
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
                    <?php 
                        // Pobierz aktualny stan magazynowy
                        $stockQuantity = getStockQuantity($productId); 
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['net_price'], 2) ?> zł</td>
                        <td><?= $product['vat'] ?>%</td>
                        <td><?= number_format($product['gross_price'], 2) ?> zł</td>
                        <td>
                            <input 
                                type="number" 
                                name="quantity[<?= htmlspecialchars($productId) ?>]" 
                                value="<?= htmlspecialchars($product['quantity']) ?>" 
                                min="1" 
                                max="<?= $stockQuantity ?>" 
                                data-stock="<?= $stockQuantity ?>" 
                                class="quantity-input"
                            >
                            <p style="font-size: 0.8em; color: gray;">(Max: <?= $stockQuantity ?>)</p>
                        </td>
                        <td class="total-price"><?= number_format($product['gross_price'] * $product['quantity'], 2) ?> zł</td>
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

        <button type="submit" name="action" value="clear">Wyczyść koszyk</button>
    </form>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalCartValueElement = document.getElementById('total-cart-value');

    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const stockQuantity = parseInt(this.dataset.stock);
            const newQuantity = Math.min(parseInt(this.value), stockQuantity);
            this.value = newQuantity; // Ogranicz wartość do maksymalnej dostępnej

            const row = this.closest('tr');
            const netPrice = parseFloat(row.querySelector('td:nth-child(2)').innerText);
            const vat = parseFloat(row.querySelector('td:nth-child(3)').innerText) / 100;
            const grossPrice = netPrice * (1 + vat) * newQuantity;
            row.querySelector('.total-price').innerText = grossPrice.toFixed(2) + ' zł';

            // Zaktualizuj całkowitą wartość koszyka
            let totalCartValue = 0;
            document.querySelectorAll('.total-price').forEach(element => {
                totalCartValue += parseFloat(element.innerText);
            });
            totalCartValueElement.innerText = totalCartValue.toFixed(2) + ' zł';
        });
    });
});
</script>
