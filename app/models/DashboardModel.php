<?php
/**
 * Dashboard Model
 * Handles all analytics queries for the main dashboard
 */
class DashboardModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /** Total revenue (completed sales only) */
    public function getTotalRevenue(): float {
        $stmt = $this->db->query("SELECT COALESCE(SUM(total_amount),0) as total FROM sales WHERE status='completed'");
        return (float) $stmt->fetch()['total'];
    }

    /** Total number of orders */
    public function getTotalOrders(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM sales");
        return (int) $stmt->fetch()['total'];
    }

    /** Total customers */
    public function getTotalCustomers(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM customers");
        return (int) $stmt->fetch()['total'];
    }

    /** Average order value */
    public function getAverageOrderValue(): float {
        $stmt = $this->db->query("SELECT COALESCE(AVG(total_amount),0) as avg FROM sales WHERE status='completed'");
        return (float) $stmt->fetch()['avg'];
    }

    /** Monthly revenue for last 12 months (for line chart) */
    public function getMonthlyRevenue(): array {
        $stmt = $this->db->query("
            SELECT 
                DATE_FORMAT(sale_date, '%b %Y') as month,
                DATE_FORMAT(sale_date, '%Y-%m') as month_key,
                COALESCE(SUM(total_amount),0) as revenue,
                COUNT(*) as orders
            FROM sales
            WHERE status='completed'
              AND sale_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY month_key, month
            ORDER BY month_key ASC
        ");
        return $stmt->fetchAll();
    }

    /** Sales by product category (for pie/donut chart) */
    public function getSalesByCategory(): array {
        $stmt = $this->db->query("
            SELECT 
                p.category,
                COALESCE(SUM(s.total_amount),0) as revenue,
                COUNT(s.id) as orders
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE s.status='completed'
            GROUP BY p.category
            ORDER BY revenue DESC
        ");
        return $stmt->fetchAll();
    }

    /** Top 5 best-selling products */
    public function getTopProducts(): array {
        $stmt = $this->db->query("
            SELECT 
                p.name,
                p.category,
                SUM(s.quantity) as units_sold,
                SUM(s.total_amount) as revenue
            FROM sales s
            JOIN products p ON s.product_id = p.id
            WHERE s.status='completed'
            GROUP BY p.id, p.name, p.category
            ORDER BY revenue DESC
            LIMIT 5
        ");
        return $stmt->fetchAll();
    }

    /** Recent 10 transactions */
    public function getRecentSales(): array {
        $stmt = $this->db->query("
            SELECT 
                s.id,
                c.name as customer_name,
                p.name as product_name,
                s.quantity,
                s.total_amount,
                s.status,
                s.sale_date
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            JOIN products p ON s.product_id = p.id
            ORDER BY s.created_at DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    /** Sales status breakdown */
    public function getStatusBreakdown(): array {
        $stmt = $this->db->query("
            SELECT status, COUNT(*) as count, SUM(total_amount) as total
            FROM sales
            GROUP BY status
        ");
        return $stmt->fetchAll();
    }

    /** Revenue comparison: this month vs last month */
    public function getMonthComparison(): array {
        $stmt = $this->db->query("
            SELECT
                SUM(CASE WHEN MONTH(sale_date)=MONTH(CURDATE()) AND YEAR(sale_date)=YEAR(CURDATE()) THEN total_amount ELSE 0 END) as this_month,
                SUM(CASE WHEN MONTH(sale_date)=MONTH(DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) AND YEAR(sale_date)=YEAR(DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) THEN total_amount ELSE 0 END) as last_month
            FROM sales WHERE status='completed'
        ");
        return $stmt->fetch();
    }
}
