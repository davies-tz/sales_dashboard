<?php
/**
 * Customers Controller
 */
class CustomersController {
    private CustomersModel $model;

    public function __construct() {
        $this->model = new CustomersModel();
    }

    public function index(): void {
        $data = [
            'title'     => 'Customers',
            'customers' => $this->model->getAll(),
        ];
        $this->render('customers/index', $data);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':name'    => htmlspecialchars($_POST['name']),
                ':email'   => htmlspecialchars($_POST['email']),
                ':phone'   => htmlspecialchars($_POST['phone'] ?? ''),
                ':city'    => htmlspecialchars($_POST['city'] ?? ''),
                ':country' => htmlspecialchars($_POST['country'] ?? 'Tanzania'),
            ];
            $this->model->create($data);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Customer added!'];
            header('Location: ' . BASE_URL . '/customers');
            exit;
        }
    }

    public function delete(): void {
        if (isset($_GET['id'])) {
            $this->model->delete((int)$_GET['id']);
            $_SESSION['flash'] = ['type'=>'success', 'msg'=>'Customer removed.'];
        }
        header('Location: ' . BASE_URL . '/customers');
        exit;
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }
}
