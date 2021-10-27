<?php

require './methods.php';

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=shop_db', 'root', '');

$query = "SELECT id , name FROM categories ORDER BY name DESC";

$statement = $pdo->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $q = "  INSERT INTO products (name, description,stock,price,is_active,image,category_id) 
            VALUE (:name, :description,:stock,:price,:is_active,:image,:category_id)
        ";

    $statement = $pdo->prepare($q);
    $image_path = upload_image();
    $is_active = isset($_POST['is_active']) ? true : false;
    $statement->bindValue(':name', $_POST['name']);
    $statement->bindValue(':description', $_POST['description']);
    $statement->bindValue(':stock', $_POST['stock']);
    $statement->bindValue(':price', $_POST['price']);
    $statement->bindValue(':is_active', $is_active);
    $statement->bindValue(':image', $image_path);
    $statement->bindValue(':category_id', $_POST['category_id']);

    $statement->execute();

    header('Location: ../index.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.css">
</head>

<body>

    <main class="container">
        <h1>Create Product</h1>

        <form action="" method="POST" enctype="multipart/form-data">

            <input placeholder="product name" name="name" type="text" class="mb-3 form-control">
            <textarea placeholder="product description" name="description" class="mb-3 form-control"></textarea>
            <input placeholder="product stock" name="stock" type="number" class="mb-3 form-control">
            <input placeholder="product price" name="price" type="number" class="mb-3 form-control">
            <input name="image" type="file" class="mb-3 form-control">

            <select name="category_id" class="mb-3  form-select">
                <?php foreach ($categories as $c) : ?>
                    <option value="<?php echo $c['id'] ?>"><?php echo ucfirst($c['name']) ?></option>
                <?php endforeach ?>
            </select>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input">
                <label for="is_active" class="form-check-label">is product active </label>
            </div>

            <button class="btn btn-success">Post</button>
        </form>
    </main>

</body>

</html>