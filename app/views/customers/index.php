<div class="page-actions">
    <button class="btn btn-primary" onclick="document.getElementById('addCustomerModal').classList.add('show')">
        + Add Customer
    </button>
</div>

<div class="card">
    <table class="data-table data-table-full">
        <thead>
            <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Orders</th><th>Total Spent</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td class="text-muted"><?= $c['id'] ?></td>
            <td>
                <div class="customer-cell">
                    <div class="customer-avatar"><?= strtoupper(substr($c['name'],0,2)) ?></div>
                    <?= htmlspecialchars($c['name']) ?>
                </div>
            </td>
            <td class="text-muted"><?= htmlspecialchars($c['email']) ?></td>
            <td><?= htmlspecialchars($c['phone'] ?? '—') ?></td>
            <td><?= htmlspecialchars($c['city'] ?? '—') ?></td>
            <td><?= number_format($c['total_orders']) ?></td>
            <td>TZS <?= number_format($c['total_spent']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>/customers/delete?id=<?= $c['id'] ?>"
                   class="btn-danger-sm"
                   onclick="return confirm('Delete this customer and all their sales?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Add Customer Modal -->
<div id="addCustomerModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3>Add New Customer</h3>
            <button class="modal-close" onclick="document.getElementById('addCustomerModal').classList.remove('show')">✕</button>
        </div>
        <form action="<?= BASE_URL ?>/customers/create" method="POST">
            <div class="form-grid">
                <div class="form-group form-full">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Amina Hassan">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="amina@email.com">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="+255...">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="e.g. Dar es Salaam">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="Tanzania">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Customer</button>
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('addCustomerModal').classList.remove('show')">Cancel</button>
            </div>
        </form>
    </div>
</div>
