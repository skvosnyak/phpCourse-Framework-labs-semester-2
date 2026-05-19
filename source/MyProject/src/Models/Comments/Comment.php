<?php
namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Services\DB;

class Comment extends ActiveRecordEntity
{
  protected $authorId;
  protected $articleId;
  protected $text;
  protected $postedAt;

  public function getText(): string
  {
    return $this->text;
  }

  public function getAuthorId(): int
  {
    return $this->authorId;
  }

  public function getAuthor(): User
  {
    return User::getById($this->authorId);
  }

  public function getArticleId(): int
  {
    return $this->articleId;
  }

  public function getArticle(): Article
  {
    return Article::getById($this->articleId);
  }

  public function setText(string $text): void
  {
    $this->text = $text;
  }

  public function setAuthor(User $author): void
  {
    $this->authorId = $author->getId();
  }

  public function setArticle(Article $article): void
  {
    $this->articleId = $article->getId();
  }

  protected static function getTableName(): string
  {
    return 'comments';
  }
  public static function findByArticleId(int $articleId): array
  {
    $db = DB::getInstance();
    $result = $db->query(
      'SELECT * FROM ' . static::getTableName() . ' WHERE article_id = :articleId',
      [':articleId' => $articleId],
      static::class
    );
    return $result;
  }
}