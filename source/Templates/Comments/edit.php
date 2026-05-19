<?php
/**
 * @var \MyProject\Models\Comments\Comment $comment
 */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Редактирование комментария</title>
</head>

<body>
  <h1>Редактирование комментария</h1>

  <form method="post" action="/comments/<?= $comment->getId() ?>/edit">
    <label>Текст комментария:
      <input type="text" name="text" value="<?= htmlspecialchars($comment->getText()) ?>">
    </label>
    <button type="submit">Сохранить</button>
  </form>

  <a href="/articles/<?= $comment->getArticleId() ?>">Отмена</a>
</body>

</html>