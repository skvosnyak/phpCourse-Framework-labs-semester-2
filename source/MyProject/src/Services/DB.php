<?php
namespace MyProject\Services;

class DB
{
  private $pdo;
  private static $instance;

  private function __construct()
  {

    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');

    $this->pdo = new \PDO(
      "pgsql:host=$host;port=$port;dbname=$dbname",
      $user,
      $password
    );
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
  {
    $sth = $this->pdo->prepare($sql);
    $result = $sth->execute($params);
    if (false === $result) {
      return null;
    }
    return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
  }
}