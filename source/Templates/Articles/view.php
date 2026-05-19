<?php
/**
 * @var \MyProject\Models\Articles\Article $article
 */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($article->getName()) ?></title>
  <style>
    .authorInfo {
      display: none;
      margin-top: 10px;
      padding: 10px;
      background-color: #f0f0f0;
      border-radius: 5px;
    }

    .authorInfo.open {
      display: block;
    }

    .authorButton {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .authorButton:hover {
      background-color: #0056b3;
    }

    .content {
      margin: 20px 0;
      line-height: 1.6;
    }
  </style>
</head>

<body>
  <h1><?= $article->getName() ?></h1>

  <p>ID статьи: <?= htmlspecialchars($article->getId()) ?></p>

  <div class="content">
    <?= $article->getText() ?>
  </div>

  <button class="authorButton">Узнать автора</button>
  <div class="authorInfo">
    Имя автора: <?= htmlspecialchars($article->getAuthor()->getNickname()) ?>
  </div>
  <br>
  <a href="/articles/<?= $article->getId() ?>/edit">Редактировать запись</a>
  <br>
  <a href="/">На главную</a>
  <br>
  <a href="/articles/<?= htmlspecialchars($article->getId()) ?>/comments">Комментарии</a>
  <script defer>
    const button = document.querySelector('.authorButton');
    const authorInfo = document.querySelector('.authorInfo');

    if (button && authorInfo) {
      button.addEventListener('click', function () {
        authorInfo.classList.toggle('open');
        button.textContent = authorInfo.classList.contains('open')
          ? 'Скрыть автора'
          : 'Узнать автора';
      });
    }
  </script>
</body>

</html>