<?php
// Connect to the database, and execute a query
class Database
{
  public $connection;

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
    $statement = $this->connection->prepare($query);

    // parameters binding 來防止注入攻擊
    $statement->execute($params);
    return $statement;
  }
}
