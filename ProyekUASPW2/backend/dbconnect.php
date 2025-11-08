<?php
class DBController
{
  public $conn;

  // koneksi database
  public function __construct()
  {
    $servername = "127.0.0.1";
    $dbname = "e_commerce_artist";
    $username = "root";
    $password = "";

    try {
      $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }

  // mengambil data dari database
  public function getRows($table, $conditions = array())
  {
    $sql = 'SELECT ';
    $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
    $sql .= ' FROM ' . $table;

    $params = [];
    // where
    if (array_key_exists("where", $conditions)) {
      $sql .= ' WHERE ';
      $clauses = [];
      foreach ($conditions['where'] as $key => $value) {
        $clauses[] = "$key = ?";
        $params[] = $value;
      }
      $sql .= implode(' AND ', $clauses);
    }

    // order by
    if (array_key_exists("order_by", $conditions)) {
      $sql .= ' ORDER BY ' . $conditions['order_by'];
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return !empty($data) ? $data : false;
  }

  // insert
  public function insert($table, $data)
  {
    try {
      if (!empty($data) && is_array($data)) {
        $columnString = implode(',', array_keys($data));
        $valueString = ":" . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . $table . " (" . $columnString . ") VALUES (" . $valueString . ")";

        $query = $this->conn->prepare($sql);
        foreach ($data as $key => $val) {
          $query->bindValue(':' . $key, $val);
        }

        return $query->execute();
      }
    } catch (PDOException $e) {
      error_log("Insert Error: " . $e->getMessage());
    }
    return false;
  }

  // update
  public function update($table, $data, $conditions = array())
  {
    if (!empty($data) && is_array($data)) {
      $colvalSet = '';
      $whereSql = '';
      $i = 0;
      foreach ($data as $key => $val) {
        $pre = ($i > 0) ? ', ' : '';
        $colvalSet .= $pre . $key . "='" . $val . "'";
        $i++;
      }
      if (!empty($conditions) && is_array($conditions)) {
        $whereSql .= ' WHERE ';
        $i = 0;
        foreach ($conditions as $key => $value) {
          $pre = ($i > 0) ? ' AND ' : '';
          $whereSql .= $pre . $key . " = '" . $value . "'";
          $i++;
        }
      }
      $sql = "UPDATE " . $table . " SET " . $colvalSet . $whereSql;

      $query = $this->conn->prepare($sql);

      $update = $query->execute();
      return $update ? true : false;
    } else {
      return false;
    }
  }

  // menjalankan query raw
  public function runRawQuery($sql, $params = [])
  {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Query Error: " . $e->getMessage());
      return false;
    }
  }

  
  public function delete($table, $conditions)
  {
    $whereSql = '';
    if (!empty($conditions) && is_array($conditions)) {
      $whereSql .= ' WHERE ';
      $i = 0;
      foreach ($conditions as $key => $value) {
        $pre = ($i > 0) ? ' AND ' : '';
        $whereSql .= $pre . $key . " = '" . $value . "'";
        $i++;
      }
    }
    $sql = "DELETE FROM " . $table . $whereSql;
    $delete = $this->conn->exec($sql);
    return $delete ? true : false;
  }
}
?>