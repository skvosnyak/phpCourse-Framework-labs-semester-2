<?php
namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Comments\Comment;

class CommentsController
{
  /** @var View */
  private $view;

  public function __construct()
  {
    $this->view = new View('/var/www/Templates');
  }

  public function edit(int $commentId): void
  {
    $comment = Comment::getById($commentId);
    if ($comment === null) {
      http_response_code(404);
      $this->view->renderHtml('errors/404.php');
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $comment->setText($_POST['text'] ?? '');
      $comment->save();
      header('Location: /articles/' . $comment->getArticleId());
      exit;
    }

    $this->view->renderHtml('Comments/edit.php', ['comment' => $comment]);
  }
}