<?php
/**
 * Products Controller
 */
class ProductsController {
    private ProductsModel $model;

    public function __construct() {
        $this->model = new ProductsModel();
    }

    public function index(): void {
        $data = [
            'title'       => 'Products',
            'products'    => $this->model->getAll(),
            'low_stock'   => $this->model->getLowStock(20),
        ];
        $this->render('products/index', $data);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':name'     => htmlspecialchars($_POST['name']),
                ':category' => htmlspecialchars($_POST['category']),
                ':price'    => (float)$_POST['price'],
                ':stock'    => (int)$_POST['stock'],
            ];
            $this->model->create($data);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Product added successfully!'];
            header('Location: ' . BASE_URL . '/products');
            exit;
        }
    }

    public function delete(): void {
        if (isset($_GET['id'])) {
            $this->model->delete((int)$_GET['id']);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Product deleted.'];
        }
        header('Location: ' . BASE_URL . '/products');
        exit;
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }
}
