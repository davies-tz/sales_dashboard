<?php
/**
 * Sales Controller - Full CRUD
 */
class SalesController {
    private SalesModel $model;
    private ProductsModel $productsModel;
    private CustomersModel $customersModel;

    public function __construct() {
        $this->model           = new SalesModel();
        $this->productsModel   = new ProductsModel();
        $this->customersModel  = new CustomersModel();
    }

    public function index(): void {
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 15;
        $offset = ($page - 1) * $limit;

        $data = [
            'title'      => 'Sales Management',
            'sales'      => $this->model->getAll($limit, $offset),
            'total'      => $this->model->getCount(),
            'page'       => $page,
            'limit'      => $limit,
            'products'   => $this->productsModel->getAll(),
            'customers'  => $this->customersModel->getAll(),
        ];
        $this->render('sales/index', $data);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $this->productsModel->getById((int)$_POST['product_id']);
            $data = [
                ':customer_id' => (int)$_POST['customer_id'],
                ':product_id'  => (int)$_POST['product_id'],
                ':quantity'    => (int)$_POST['quantity'],
                ':unit_price'  => $product['price'],
                ':status'      => $_POST['status'] ?? 'completed',
                ':sale_date'   => $_POST['sale_date'],
            ];
            $id = $this->model->create($data);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Sale #'.$id.' created successfully!'];
            header('Location: ' . BASE_URL . '/sales');
            exit;
        }
    }

    public function delete(): void {
        if (isset($_GET['id'])) {
            $this->model->delete((int)$_GET['id']);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Sale deleted.'];
        }
        header('Location: ' . BASE_URL . '/sales');
        exit;
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }
}
