<?php

namespace App;
require_once 'settings.php';

use PDO;


class Storage
{
    private $pdo;
    private static $instance = null;

    public function __construct()
    {
        $connection = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET . ";port=" . DB_PORT;
        $this->pdo = new PDO($connection, DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Storage();
        }
        return self::$instance;
    }

    public function getPizzas()
    {
        return $this->getProducts('Пицца');
    }

    public function getSauses()
    {
        return $this->getProducts('Соус');
    }

    public function getSizes()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sizes");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPizza(int $id, int $sizeId)
    {
        return $this->getProductById($id, $sizeId);
    }

    public function getSause(int $id)
    {
        return $this->getProductById($id);
    }

    private function getProductById(int $id, $sizeId = null)
    {
        $sql = "SELECT p.name as name, p.basePrice as basePrice, t.name as type, s.name as size, ts.coef as coef
                FROM products as p
                INNER JOIN types as t ON p.typeId = t.id
                LEFT JOIN type_sizes as ts ON t.id = ts.typeId
                LEFT JOIN sizes as s ON ts.sizeId = s.id";

        $where = "p.id = :id";
        if ($sizeId !== null) {
            $where .= " AND s.id = :sizeId";
        }

        $stmt = $this->pdo->prepare($sql . " WHERE " . $where);
        if ($sizeId !== null) {
            $stmt->execute(['id' => $id, 'sizeId' => $sizeId]);
        } else {
            $stmt->execute(['id' => $id]);
        }
        return $stmt->fetch();
    }

    private function getProducts($type)
    {
        $sql = "SELECT products.* FROM products INNER JOIN types ON products.typeId = types.id WHERE types.name = :typeName";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['typeName' => $type]);
        return $stmt->fetchAll();
    }
}