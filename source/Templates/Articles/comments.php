<?php
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($article->getName()) ?></title>
  <style>
    .commentForm {
      display: none;
    }

    .commentForm.open {
      display: flex;
      flex-direction: column;
    }

    .submitComment {
      align-self: flex-start;
    }

    .addButton,
    .submitComment {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .addButton:hover,
    .submitComment:hover {
      background-color: #0056b3;
    }

    input {
      border: 1px solid #212121;
      border-radius: 15px;
      padding: 10px;
      margin-top: 15px;
    }

    ul {
      list-style: none;
      padding-inline-start: 0;
    }

    .liComment {
      margin-bottom: 15px;
      padding: 20px;
      border-radius: 15px;
      background-color: #d3e2f3;
    }
  </style>
</head>

<body>
  <h1><?= $article->getName() ?></h1>
  <ul class="comments"></ul>
  <br>
  <button class="addButton">Добавить комментарий</button>

  <form class="commentForm" method="post" action="/articles/<?= $article->getId() ?>/addComment">
    <label>Имя автора:
      <input type="text" name="authorName">
    </label>

    <label>Комментарий:
      <input type="text" name="comment">
    </label>
    <button class="submitComment" type="submit">Отправить комментарий</button>
  </form>

  <script defer>
    const comments = <?= json_encode(array_map(fn($c) => [
      'id' => $c->getId(),
      'text' => $c->getText(),
      'author' => $c->getAuthor()->getNickname(),
    ], $comments)) ?>;

    const list = document.querySelector('.comments');
    comments.forEach(comment => {
      const li = document.createElement('li');
      li.classList.add("liComment");
      li.id = 'comment' + comment.id;
      li.textContent = comment.author + ': ' + comment.text;
      list.appendChild(li);
      const link = document.createElement('a');
      link.textContent = "Редактировать";
      link.setAttribute('href', '/comments/' + comment.id + '/edit');
      li.appendChild(link);
    });

    const addButton = document.querySelector(".addButton");
    const commentForm = document.querySelector(".commentForm");
    addButton.addEventListener("click", () => {
      commentForm.classList.toggle('open');
      addButton.textContent = commentForm.classList.contains('open')
        ? 'Не добавлять комментарий'
        : 'Добавить комментарий';
    });
  </script>
</body>

</html>