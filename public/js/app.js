/**
 * SalesPulse Analytics - Main JS
 */

// Close modals on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(m => m.classList.remove('show'));
    }
});

// Auto-dismiss flash messages
const flash = document.querySelector('.flash');
if (flash) {
    setTimeout(() => {
        flash.style.opacity = '0';
        flash.style.transition = 'opacity 0.5s';
        setTimeout(() => flash.remove(), 500);
    }, 3500);
}

// Table row hover highlight
document.querySelectorAll('.data-table tbody tr').forEach(row => {
    row.style.cursor = 'default';
    row.style.transition = 'background 0.15s';
});

console.log('%cSalesPulse Analytics v1.0', 'color:#6EE7B7; font-family:monospace; font-size:14px;');
