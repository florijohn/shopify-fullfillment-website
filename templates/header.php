<a href="<?= $basepath ?>/de/"><img id="logo" src="<?= $basepath ?>/images/logos/mymathcalculator.png"></a>
<nav>
    <?php require(__DIR__ . "/navigation.php"); ?>
</nav>
<ul id="lang">
<?php foreach ($locales as $loc): ?>
    <li><a href="<?= $basepath ?>/<?= $loc; ?>/" title="<?= $loc; ?>"><?= $loc; ?></a></li>
<?php endforeach; ?>
</ul>
