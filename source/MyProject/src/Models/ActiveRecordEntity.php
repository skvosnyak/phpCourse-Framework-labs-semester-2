<?php

namespace MyProject\Models;

use MyProject\Services\DB;

abstract class ActiveRecordEntity
{
  protected $id;
  public function getId(): int
  {
    return $this->id;
  }
  public function __set(string $name, $value)
  {
    $camelCaseName = $this->underscoreToCamelCase($name);
    $this->$camelCaseName = $value;
  }

  private function underscoreToCamelCase(string $source): string
  {
    return lcfirst(str_replace('_', '', ucwords($source, '_')));
  }

  public static function findAll(): array
  {
    $db = DB::getInstance();
    return $db->query('SELECT * FROM ' . static::getTableName(), [], static::class);
  }

  public static function getById(int $id): ?self
  {
    $db = DB::getInstance();
    $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id';
    $entities = $db->query($sql, [':id' => $id], static::class);
    return $entities ? $entities[0] : null;
  }
  private function mapPropertiesToDbFormat(): array
  {
    $reflector = new \ReflectionObject($this);
    $properties = $reflector->getProperties();
    $mappedProperties = [];

    foreach ($properties as $property) {
      $propertyName = $property->getName();
      $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
      $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
    }
    return $mappedProperties;
  }
  private function camelCaseToUnderscore(string $source): string
  {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
  }
  public function save(): void
  {
    $mappedProperties = $this->mapPropertiesToDbFormat();
    if ($this->id !== null) {
      $this->update($mappedProperties);
    } else {
      $this->insert($mappedProperties);
    }
  }

  private function update(array $mappedProperties): void
  {
    $setClauses = [];
    $params = [];

    foreach ($mappedProperties as $column => $value) {
      if ($column === 'id') {
        continue;
      }
      $setClauses[] = $column . ' = :' . $column;
      $params[':' . $column] = $value;
    }

    $params[':id'] = $this->id;

    $sql = 'UPDATE ' . static::getTableName() .
      ' SET ' . implode(', ', $setClauses) .
      ' WHERE id = :id';

    $db = DB::getInstance();
    $db->query($sql, $params);
  }

  private function insert(array $mappedProperties): void
  {
    $filteredProperties = array_filter($mappedProperties, function ($value) {
      return $value !== null;
    });
    unset($filteredProperties['id']);

    $columns = [];
    $params = [];

    foreach ($filteredProperties as $columnName => $value) {
      $columns[] = $columnName;
      $params[':' . $columnName] = $value;
    }

    $placeholders = array_map(
      fn($column) => ':' . $column,
      $columns
    );

    $sql = 'INSERT INTO ' . static::getTableName() .
      ' (' . implode(', ', $columns) . ')' .
      ' VALUES (' . implode(', ', $placeholders) . ')';

    $db = DB::getInstance();
    $db->query($sql, $params);
  }

  public function delete(): void
  {
    $db = DB::getInstance();
    $db->query(
      'DELETE FROM ' . static::getTableName() . ' WHERE id = :id',
      [':id' => $this->id]
    );
    $this->id = null;
  }

  abstract protected static function getTableName(): string;
}