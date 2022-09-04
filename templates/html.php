<!DOCTYPE html>
<html lang="<?= $page->locale ?>">
    <head>
        <?php require(__DIR__ . "/head.php"); ?>
    </head>

    <body>
        <header>
            <?php require(__DIR__ . "/header.php"); ?>
        </header>
        <div id="page">
            <main>
                <h1><?= $page->title ?></h1>
                <?php require(__DIR__ . "/main.php"); ?>
            </main>
            <footer>
                <?php require(__DIR__ . "/footer.php"); ?>
            </footer>
        </div>
    </body>
</html>
