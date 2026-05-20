<?php $totalPages = ceil($total / $limit); ?>

<div class="page-actions">
    <button class="btn btn-primary" onclick="document.getElementById('addSaleModal').classList.add('show')">
        + New Sale
    </button>
</div>

<div class="card">
    <table class="data-table data-table-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($sales)): ?>
            <tr><td colspan="8" class="text-center text-muted">No sales records found.</td></tr>
        <?php else: ?>
            <?php foreach ($sales as $s): ?>
            <tr>
                <td class="text-muted"><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['customer_name']) ?></td>
                <td><?= htmlspecialchars($s['product_name']) ?></td>
                <td><?= $s['quantity'] ?></td>
                <td>TZS <?= number_format($s['total_amount']) ?></td>
                <td><span class="status-badge status-<?= $s['status'] ?>"><?= $s['status'] ?></span></td>
                <td><?= date('M d, Y', strtotime($s['sale_date'])) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>/sales/delete?id=<?= $s['id'] ?>"
                       class="btn-danger-sm"
                       onclick="return confirm('Delete this sale?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i=1; $i<=$totalPages; $i++): ?>
            <a href="?page=<?= $i ?>" class="page-btn <?= $i===$page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Add Sale Modal -->
<div id="addSaleModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3>Record New Sale</h3>
            <button class="modal-close" onclick="document.getElementById('addSaleModal').classList.remove('show')">✕</button>
        </div>
        <form action="<?= BASE_URL ?>/sales/create" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" required>
                        <option value="">— Select —</option>
                        <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Product</label>
                    <select name="product_id" required>
                        <option value="">— Select —</option>
                        <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?> (TZS <?= number_format($p['price']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group form-full">
                    <label>Sale Date</label>
                    <input type="date" name="sale_date" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Sale</button>
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addSaleModal').classList.remove('show')">Cancel</button>
            </div>
        </form>
    </div>
</div>
