<?php

require_once '../src/model/Database.php';
require_once '../src/model/Formulary.php';

$database = new Database;
$bribes = $database->readBribes();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $formData = array_map('trim', $_POST);
    $errors = (new Formulary())->validateForm($formData);
    if (empty($errors)) {
        $database->addBribe($formData);
        header('location: /book.php');
    }
}

if (isset($_GET['letter'])) {
    $letters = trim($_GET['letter']);
    $letters = $letters;
    $validateLetter = (new Formulary())->validateLetter($letters);
    if ($validateLetter === false) {
        $bribes = $database->readByLetter($letters);
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/book.css">
        <title>Checkpoint PHP 1</title>
    </head>
    <body>
        <?php include 'header.html'; ?>
        <main class="container">
            <section class="index">
                <a href="/book.php">ALL</a>
                <?php foreach (range('A', 'Z') as $letter) : ?>
                    <a href="/book.php?letter=<?= $letter ?>"><?= $letter ?></a>
                <?php endforeach ?>
            </section>
            <section class="desktop">
                <div class="whiskeys">
                    <img src="image/whisky.png" alt="a whisky glass" class="whisky"/>
                    <img src="image/empty_whisky.png" alt="an empty whisky glass" class="empty-whisky"/>
                </div>
                <div class="pages">
                    <div class="page leftpage">
                    <div class="titleForm">Add a bribe</div>
                        <form action="" method="POST">
                            <?php if (!empty($errors)) : ?>
                                <ul class="error">
                                    <?php foreach ($errors as $error) : ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <div>
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" >

                                <label for="payment">Payment</label>
                                <input type="number" id="payment" name="payment" >
                            </div>
                            <div  class="button">
                                <button type="submit" class="button">Pay!</button>
                            </div>
                        </form>
                    </div>
                    <div class="page rightpage">
                        <div class="titleLetter"><?= $letters ?? 'ALL' ?></div>
                        <table>
                            <thead>
                            </thead>
                            <tbody>
                                <?php foreach ($bribes as $bribe) : ?>
                                    <tr>
                                        <td class="left"><?= $bribe->name; ?></td>
                                        <td><?= $bribe->payment . '$'; ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="left-foot">Total</td>
                                    <td class=underline-top>
                                        <?php $sum = 0; ?>
                                        <?php foreach ($bribes as $bribe) : ?>
                                            <?php $sum += $bribe->payment ?>
                                        <?php endforeach ?>
                                        <?= $sum . '$'; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="pen">
                    <img src="image/inkpen.png" alt="an ink pen" class="inkpen"/>
                </div>
            </section>
        </main>
    </body>
</html>
