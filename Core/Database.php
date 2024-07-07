<?php
// Connect to the database, and execute a query
namespace Core;

use PDO;

use PDOException;

class Database
{
  public $connection;

  public $statement;

  public function __construct($config)
  {
    $dsn = 'mysql:' . http_build_query($config, '', ';');

    try {
      $this->connection = new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public function query($query, $params = [])
  {
    $this->statement = $this->connection->prepare($query);

    // parameters binding 來防止注入攻擊
    $this->statement->execute($params);
    return $this;
  }

  public function get()
  {
    return $this->statement->fetchAll();
  }

  public function find()
  {
    return $this->statement->fetch();
  }

  public function findOrFail()
  {
    $result = $this->find();
    if (!$result) {
      abort();
    }
    return $result;
  }
}
