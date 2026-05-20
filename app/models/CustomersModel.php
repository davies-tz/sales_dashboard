<?php
/**
 * Customers Model
 */
class CustomersModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        return $this->db->query("
            SELECT c.*, COUNT(s.id) as total_orders, COALESCE(SUM(s.total_amount),0) as total_spent
            FROM customers c
            LEFT JOIN sales s ON c.id = s.customer_id AND s.status='completed'
            GROUP BY c.id ORDER BY total_spent DESC
        ")->fetchAll();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("
            INSERT INTO customers (name, email, phone, city, country) VALUES (:name, :email, :phone, :city, :country)
        ");
        $stmt->execute($data);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE customers SET name=:name, email=:email, phone=:phone, city=:city, country=:country WHERE id=:id
        ");
        return $stmt->execute([...$data, ':id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
