<?php
/**
 * Dashboard Controller
 * MVC Pattern - Controller Layer
 */
class DashboardController {
    private DashboardModel $model;

    public function __construct() {
        $this->model = new DashboardModel();
    }

    public function index(): void {
        $data = [
            'title'           => 'Dashboard Overview',
            'total_revenue'   => $this->model->getTotalRevenue(),
            'total_orders'    => $this->model->getTotalOrders(),
            'total_customers' => $this->model->getTotalCustomers(),
            'avg_order_value' => $this->model->getAverageOrderValue(),
            'monthly_revenue' => $this->model->getMonthlyRevenue(),
            'sales_by_category' => $this->model->getSalesByCategory(),
            'top_products'    => $this->model->getTopProducts(),
            'recent_sales'    => $this->model->getRecentSales(),
            'status_breakdown'=> $this->model->getStatusBreakdown(),
            'month_comparison'=> $this->model->getMonthComparison(),
        ];
        $this->render('dashboard/index', $data);
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }
}
