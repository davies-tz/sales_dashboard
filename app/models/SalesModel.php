<?php
/**
 * Sales Model
 * CRUD operations for sales records
 */
class SalesModel {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(int $limit = 50, int $offset = 0): array {
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as customer_name, p.name as product_name, p.category
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            JOIN products p ON s.product_id = p.id
            ORDER BY s.sale_date DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCount(): int {
        return (int) $this->db->query("SELECT COUNT(*) FROM sales")->fetchColumn();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT s.*, c.name as customer_name, p.name as product_name
            FROM sales s
            JOIN customers c ON s.customer_id = c.id
            JOIN products p ON s.product_id = p.id
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare("
            INSERT INTO sales (customer_id, product_id, quantity, unit_price, status, sale_date)
            VALUES (:customer_id, :product_id, :quantity, :unit_price, :status, :sale_date)
        ");
        $stmt->execute([
            ':customer_id' => $data['customer_id'],
            ':product_id'  => $data['product_id'],
            ':quantity'    => $data['quantity'],
            ':unit_price'  => $data['unit_price'],
            ':status'      => $data['status'] ?? 'completed',
            ':sale_date'   => $data['sale_date'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE sales SET customer_id=:customer_id, product_id=:product_id,
            quantity=:quantity, unit_price=:unit_price, status=:status, sale_date=:sale_date
            WHERE id=:id
        ");
        return $stmt->execute([...$data, ':id' => $id]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM sales WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
