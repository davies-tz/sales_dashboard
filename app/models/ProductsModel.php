<?php
/**
 * Products Model
 */
class ProductsModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        return $this->db->query("SELECT * FROM products ORDER BY name ASC")->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("
            INSERT INTO products (name, category, price, stock) VALUES (:name, :category, :price, :stock)
        ");
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE products SET name=:name, category=:category, price=:price, stock=:stock WHERE id=:id
        ");
        return $stmt->execute([...$data, ':id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getLowStock(int $threshold = 20): array {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE stock <= ? ORDER BY stock ASC");
        $stmt->execute([$threshold]);
        return $stmt->fetchAll();
    }
}
