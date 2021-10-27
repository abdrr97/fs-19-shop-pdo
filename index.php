<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=shop_db', 'root', '');

$query = "SELECT 
            products.name AS p_name ,
            products.description ,
            products.stock , 
            products.price ,
            products.image , 
            products.id AS p_id,
            categories.name AS c_name
            FROM products
            INNER JOIN categories 
            ON products.category_id = categories.id
            WHERE products.is_active = true
            ORDER BY products.created_at DESC
";

$statement = $pdo->prepare($query);
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.css">
</head>

<body>

    <main class="container">
        <section class="d-flex justify-content-between align-items-center">
            <h1 class="display-6">Products</h1>

            <a class="btn btn-info" href="./product/create.php">new product</a>
        </section>

        <section class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-4 mb-3">
                    <article class="card">
                        <div class="card-body">
                            <?php echo $product['p_name'] ?>

                            <p>
                                <?php echo $product['description'] ?>
                            </p>
                            <?php echo $product['c_name'] ?>
                        </div>

                    </article>

                    <div class="card-footer">
                        <div class="btn-group">
                            <form action="./product/delete.php" method="POST">
                                <input name="product_id" value="<?php echo $product['p_id'] ?>" type="hidden">
                                <button class="btn btn-sm btn-danger">delete</button>
                            </form>
                            <a class="btn btn-sm btn-warning" href="./product/edit.php?id=<?php echo $product['p_id'] ?>">
                                edit
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </section>

    </main>


</body>

</html>