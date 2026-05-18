<?php include $templatesPath . '/main/header.php'; ?>

<?php if (empty($articles)): ?>
    <p>Статей пока нет.</p>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
        <p><?= $article->getText() ?></p>
        <hr>
    <?php endforeach; ?>
<?php endif; ?>

<?php include $templatesPath . '/main/footer.php'; ?>