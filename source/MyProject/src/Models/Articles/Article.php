<?php
namespace MyProject\Models\Articles;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
class Article extends ActiveRecordEntity
{
  protected $id;
  protected $name;
  protected $text;
  protected $authorId;
  protected $createdAt;

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getText(): string
  {
    return $this->text;
  }

  public function setText(string $text): void
  {
    $this->text = $text;
  }

  public function setName(string $name): void
  {
    $this->name = $name;
  }

  public function getAuthor(): User
  {
    return User::getById($this->authorId);
  }

  public function setAuthor(User $author): void
  {
    $this->authorId = $author->getId();
  }

  public function getAuthorID(): int
  {
    return $this->authorId;
  }
  protected static function getTableName(): string
  {
    return 'articles';
  }
}