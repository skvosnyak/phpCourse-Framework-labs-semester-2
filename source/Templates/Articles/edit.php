<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Редактирование: <?= htmlspecialchars($article->getName()) ?></title>
</head>

<body>
  <h1>Редактирование статьи</h1>

  <form method="post" action="/articles/<?= $article->getId() ?>/save">
    <label>Название
      <input type="text" name="name" value="<?= htmlspecialchars($article->getName()) ?>">
    </label>
    <label>Текст статьи
      <textarea name="text"><?= htmlspecialchars($article->getText()) ?></textarea>
    </label>
    <button type="submit">Сохранить</button>
  </form>

  <a href="/articles/<?= $article->getId() ?>">Отмена</a>
</body>

</html>