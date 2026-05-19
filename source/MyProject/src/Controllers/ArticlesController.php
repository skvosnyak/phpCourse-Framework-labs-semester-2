<?php
namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Models\Comments\Comment;

class ArticlesController
{
  /** @var View */
  private $view;

  public function __construct()
  {
    $this->view = new View('/var/www/Templates');
  }

  public function view(int $articleId)
  {
    $article = Article::getById($articleId);
    if ($article === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }
    $this->view->renderHtml('Articles/view.php', ['article' => $article]);
  }

  public function edit(int $articleId): void
  {
    $article = Article::getById($articleId);
    if ($article === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }
    $this->view->renderHtml('Articles/edit.php', ['article' => $article]);
  }
  public function save(int $articleId): void
  {
    $article = Article::getById($articleId);
    if ($article === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }

    $article->setName($_POST['name'] ?? '');
    $article->setText($_POST['text'] ?? '');
    $article->save();

    header('Location: /articles/' . $articleId);
  }

  public function add(): void
  {
    $author = User::getById(1);

    $article = new Article();
    $article->setAuthor($author);
    $article->setName('Новое название статьи');
    $article->setText('Новый текст статьи');
    $article->save();
  }
  public function comments(int $articleId): void
  {
    $article = Article::getById($articleId);
    if ($article === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }

    $comments = Comment::findByArticleId($articleId);
    $this->view->renderHtml('Articles/comments.php', [
      'article' => $article,
      'comments' => $comments,
    ]);
  }

  public function addComment(int $articleId): void
  {
    $article = Article::getById($articleId);
    if ($article === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }

    $authorName = $_POST['authorName'] ?? '';
    $author = User::getByNickname($authorName);

    if ($author === null) {
      $this->view->renderHtml('Articles/comments.php', [
        'article' => $article,
        'comments' => Comment::findByArticleId($articleId),
        'error' => 'Пользователь "' . htmlspecialchars($authorName) . '" не найден',
      ]);
      return;
    }

    $comment = new Comment();
    $comment->setArticle($article);
    $comment->setAuthor($author);
    $comment->setText($_POST['comment'] ?? '');
    $comment->save();

    header('Location: /articles/' . $articleId . '/comments');
    exit;
  }
}