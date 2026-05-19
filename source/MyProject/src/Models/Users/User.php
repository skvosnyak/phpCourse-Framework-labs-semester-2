<?php

namespace MyProject\Models\Users;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Services\DB;
class User extends ActiveRecordEntity
{

  protected $nickname;
  protected $email;
  protected $isConfirmed;
  protected $role;
  protected $passwordHash;
  protected $authToken;
  protected $createdAt;

  public function getNickname(): string
  {
    return $this->nickname;
  }

  public static function getByNickname(string $nickname): ?self
  {
    $db = DB::getInstance();
    $entities = $db->query(
      'SELECT * FROM ' . static::getTableName() . ' WHERE nickname = :nickname',
      [':nickname' => $nickname],
      static::class
    );
    return $entities ? $entities[0] : null;
  }

  protected static function getTableName(): string
  {
    return 'users';
  }
}

