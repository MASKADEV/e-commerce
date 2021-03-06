<?php

class UserOperation {

    public function updateUserInfo($id, $full_name, $email, $address) {
        require_once('src/models/connection.php');
        $db = new Database();
        $str = 'UPDATE `users` SET full_name=?, email=?, address=? WHERE id=?';
        $query = $db->connection()->prepare($str);
        $query->execute([$full_name, $email, $address, $id]);
    }

    public function searchProducts($search) {
        require_once('src/models/connection.php');
        $db = new Database();
        // echo $search . ' asdasd';die;
        $str = 'SELECT * FROM `products` WHERE `title` LIKE ? ';
        $query = $db->connection()->prepare($str);
        $query->execute(["%".$search."%"]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function order($product_id, $order_id, $quantity, $user_id) {
        require_once('src/models/connection.php');
        // echo $product_id . ' ' . $order_id . ' ' . $quantity . ' ' . ' ' . $user_id;die;
        $db = new Database();
        $str = 'INSERT INTO `Orders` (`order_id`, `quantity`, `product_id`, `user_id`) VALUES (?, ?, ?, ?)';
        $query = $db->connection()->prepare($str);
        $query->execute([$order_id, $quantity, $product_id, $user_id]);
        // $query->execute([]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAllOrders($id) {
        require_once('src/models/connection.php');
        $db = new Database();
        $str = 'SELECT * FROM `Orders` WHERE user_id=?';
        $query = $db->connection()->prepare($str);
        $query->execute([$id]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchByCategories($categories) {
        require_once('src/models/connection.php');
        $db = new Database();
        $str = 'SELECT id FROM `categories` WHERE title=?';
        $query = $db->connection()->prepare($str);
        $query->execute([$categories]);
        $id = $query->fetch(PDO::FETCH_ASSOC)['id'];
        $str = 'SELECT products.*, categories.title AS c_title FROM `products` INNER JOIN categories ON categories.id = products.categories_id WHERE `categories_id`=?';
        $query = $db->connection()->prepare($str);
        $query->execute([$id]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchRelatedProducts($categories) {
        require_once('src/models/connection.php');
        $db = new Database();
        $str = 'SELECT products.*, categories.title AS c_title FROM `products` INNER JOIN categories ON categories.id = products.categories_id WHERE `categories_id`=?';
        $query = $db->connection()->prepare($str);
        $query->execute([$categories]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}