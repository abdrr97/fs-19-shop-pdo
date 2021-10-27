<?php

try
{
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=shop_db', 'root', '');

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $id = $_POST['product_id'];

        $query = "DELETE FROM products WHERE id = :product_id";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':product_id', $id);
        $statement->execute();
    }
    header('Location: ../index.php');
}
catch (\Throwable $th)
{
    header('Location: ../index.php');
}
