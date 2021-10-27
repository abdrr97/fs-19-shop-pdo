<?php

require './methods.php';

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=shop_db', 'root', '');

// get cateogies
$q = "  SELECT * FROM categories ORDER BY name ASC ";
$statement = $pdo->prepare($q);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

$product_id = $_GET['id'];

// get product
$q = "SELECT * FROM products WHERE id = :id ";
$statement = $pdo->prepare($q);
$statement->bindValue(':id', $product_id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

// redirect back if no id or product doesn't exists
if (!isset($_GET['id']) || empty($product))
{
    header('Location: ../index.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $q = "  UPDATE products SET 
            name = :name , description = :description ,
            stock = :stock , price = :price , 
            is_active = :is_active , image = :image ,
            category_id = :category_id 
            WHERE id = :id
        ";


    $statement = $pdo->prepare($q);
    $image_path = upload_image('image', $product['image']);
    $is_active = isset($_POST['is_active']) ? true : false;
    $statement->bindValue(':name', $_POST['name']);
    $statement->bindValue(':description', $_POST['description']);
    $statement->bindValue(':stock', $_POST['stock']);
    $statement->bindValue(':price', $_POST['price']);
    $statement->bindValue(':is_active', $is_active);
    $statement->bindValue(':image', $image_path);
    $statement->bindValue(':category_id', $_POST['category_id']);
    $statement->bindValue(':id', $product_id);

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
        <h1>Edit Product</h1>

        <form action="" method="POST" enctype="multipart/form-data">

            <input value="<?php echo $product['name'] ?>" placeholder="product name" name="name" type="text" class="mb-3 form-control">
            <textarea placeholder="product description" name="description" class="mb-3 form-control"><?php echo $product['description'] ?></textarea>
            <input value="<?php echo $product['stock'] ?>" placeholder="product stock" name="stock" type="number" class="mb-3 form-control">
            <input value="<?php echo $product['price'] ?>" placeholder="product price" name="price" type="number" class="mb-3 form-control">
            <img src="<?php echo './' . $product['image'] ?>" alt="<?php echo $product['name'] ?>">
            <input name="image" type="file" class="mb-3 form-control">
            <select name="category_id" class="mb-3  form-select">
                <?php foreach ($categories as $c) : ?>
                    <option <?php echo trim($c['id']) === trim($product['category_id']) ? 'selected' : ''  ?> value="<?php echo $c['id'] ?>">
                        <?php echo ucfirst($c['name']) ?>
                    </option>
                <?php endforeach ?>
            </select>

            <div class="mb-3 form-check">
                <input <?php echo $product['is_active'] ? 'checked' : '' ?> type="checkbox" name="is_active" id="is_active" class="form-check-input">
                <label for="is_active" class="form-check-label">is product active </label>
            </div>

            <button class="btn btn-warning">Update</button>
        </form>
    </main>

</body>

</html>