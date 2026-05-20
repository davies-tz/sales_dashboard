<div class="page-actions">
    <button class="btn btn-primary" onclick="document.getElementById('addProductModal').classList.add('show')">
        + Add Product
    </button>
</div>

<?php if (!empty($low_stock)): ?>
<div class="alert alert-warning">
    ⚠️ <?= count($low_stock) ?> product(s) with low stock (≤20 units).
</div>
<?php endif; ?>

<div class="card">
    <table class="data-table data-table-full">
        <thead>
            <tr><th>#</th><th>Name</th><th>Category</th><th>Price (TZS)</th><th>Stock</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td class="text-muted"><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><span class="tag"><?= htmlspecialchars($p['category']) ?></span></td>
            <td><?= number_format($p['price']) ?></td>
            <td>
                <span class="stock-badge <?= $p['stock'] <= 20 ? 'stock-low' : 'stock-ok' ?>">
                    <?= $p['stock'] ?>
                </span>
            </td>
            <td>
                <a href="<?= BASE_URL ?>/products/delete?id=<?= $p['id'] ?>"
                   class="btn-danger-sm"
                   onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3>Add New Product</h3>
            <button class="modal-close" onclick="document.getElementById('addProductModal').classList.remove('show')">✕</button>
        </div>
        <form action="<?= BASE_URL ?>/products/create" method="POST">
            <div class="form-grid">
                <div class="form-group form-full">
                    <label>Product Name</label>
                    <input type="text" name="name" required placeholder="e.g. Laptop Pro 15&quot;">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="Electronics">Electronics</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Food">Food</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price (TZS)</label>
                    <input type="number" name="price" min="0" step="0.01" required placeholder="e.g. 150000">
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="stock" min="0" value="0" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addProductModal').classList.remove('show')">Cancel</button>
            </div>
        </form>
    </div>
</div>
