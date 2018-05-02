<?php
/**
 * Core Base Model class
 * Model class is derived from Github user phpdave11 
 * @see https://github.com/phpdave11/php-survey-builder/blob/master/models/Model.php
 */
abstract class Model {
  
  /**
   * Returns the fields of the model.
   *
   * @return array
   */
  public static function getFields($keys_only = TRUE) {
    return ($keys_only) ? array_keys(static::$fields) : static::$fields;
  }

  /**
   * Creates a table based on the model.
   *   
   * @return int exec return code
   */
  public static function Install($additional_params = NULL) {
    
    $pdo = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!$pdo) throw new Exception('Database error.');

    $fields = static::getFields(FALSE);
    $primaryKey = static::getPrimaryKey();
    $table = static::getTable();
    $columns = implode("\r\n",array_map(function($column, $type) {
      return  $column . ' ' . $type . ',';
    },array_keys($fields),$fields));

    
    $sql = "create table $table";
    $sql .= "($columns primary key ($primaryKey) ";
    $sql .= (!is_null($additional_params)) ? $additional_params : "" .");";
    return  $pdo->exec($sql);
  }


  /**
   * Return the primary key of the table
   *
   * @return string primary key associated with the model
   */
  public static function getPrimaryKey() {
    return static::$primaryKey;
  }

  /**
   * Returns the table name
   *
   * @return array
   */
  public static function getTable() {
    return self::decamelize(get_called_class());
  }

  /**
   * Returns camelcase to lowercase, and uses underscores
   *
   * @param string $input input string (typically the class name)
   * @return string returns the string in lowercase separated by underscores
   */
  public static function decamelize($input) {
    return strtolower(preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', '_$0', $input)));
  }

  /**
   * Query the database for a record based on the primary id
   *
   * @param PDO $pdo
   * @param int $id
   * @return Model
   */
  public static function getRecordByID(PDO $pdo, $id) {
    $field = implode(', ', static::getFields());
    $table = static::getTable();
    $primaryKey = static::getPrimaryKey();
    $params = array('primary_key' => $id);

    $sql = "select $fields from $table where $primaryKey = :primary_key";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    return $stmt->fetch();
  }

  /**
   * Query the databased based on a condition.
   *
   * @param PDO $pdo
   * @param string $condition
   * @param array $params
   * @return Model
   */
  public static function queryRecordWhere(PDO $pdo, $condition, $params = NULL) {
    $field = implode(', ', static::getFields());
    $table = static::getTable();
    $primaryKey = static::getPrimaryKey();

    $sql = "select $fields from  $table where $condition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    return $stmt->fetch();
  }
  
  /**
   * Undocumented function
   *
   * @param PDO $pdo
   * @param string $condition
   * @param array $params
   * @return array<Model>
   */
  public static function queryRecordsWhere(PDO $pdo, $condition, $params = NULL) {
    $field = implode(', ', static::getFields());
    $table = static::getTable();
    $primaryKey = static::getPrimaryKey();
  
    $sql = "select $fields from  $table where $condition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    return $stmt->fetchAll();
  }

  /**
   * Undocumented function
   *
   * @param PDO $pdo
   * @param string $search
   * @return array<Model>
   */
  public static function queryRecords(PDO $pdo, $search = NULL) {
    $fields = static::getFields();
    $table = static::getTable();
    $primaryKey = static::getPrimaryKey();

    $conditionFields = array();
    $params = array();
    
    if(empty($search))
      $search = array();

    foreach($search as $field => $value ) {
      if (in_array($field, $fields)) {
        $conditionFields[] = "$field = :$field";
        $params[$field] = $value;
      }
    }

    $condition = implode(', ', $conditionFields);
    $fieldsSql = implode(', ', $fields);

    $sql = "select $fieldsSql from $table";
    
    if (! empty($condition)) 
      $sql .= " where $condition";

    if (isset($search['sort']) && in_array($search['sort'], $fields))
      $sql .= " order by " . $search['sort'];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

    return $stmt->fetchAll();
  }

  /**
   * Undocumented function
   *
   * @param PDO $pdo
   * @param string $sql
   * @param array $params
   * @return array<Model>
   */
  public static function queryRaw(PDO $pdo, $sql, $params = NULL) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    return $stmt->fetchAll();
  }

  /**
   * Model constructor
   */
  public function __construct() {
    $fields = static::getFields();
    foreach($fields as $field) {
      if (!isset($this->$field))
        $this->$field = NULL;
    }
  }

  /**
   * Initializes fields
   *
   * @param array $values
   * @return void
   */
  public function setValues($values) {
    $fields = static::getFields();
    foreach($fields as $field => $value){
      if (in_array($field, $fields))
        $this->$field = $value;
    }
  }

/**
 * Undocumented function
 *
 * @param array $values
 * @return void
 */
  public function updateValues($values) {
    $fields = static::getFields();

    foreach ($values as $field => $value) {
            if (in_array($field, $fields) && !empty($value))
                $this->$field = $value;
    }
  }

  /**
   * Removes a record
   *
   * @param PDO $pdo
   * @return mixed
   */
  public function deleteRecord(PDO $pdo) {
    $fields = static::getFields();
    $table = static::getTable();
    $primaryKey = static::getPrimaryKey();

    if (! empty($this->$primaryKey)) {
      $sql = "delete from $table where $primaryKey = :primary_key";

      $params = array();
      $params['primary_key'] = $this->$primaryKey;

      $stmt = $pdo->prepare($sql);
      return $stmt->execute($params);
    }
  }
  
/**
 * Stores a record in the db
 *
 * @param PDO $pdo
 * @return void
 */
  public function storeRecord(PDO $pdo){
      $fields = static::getFields();
      $table = static::getTable();
      $primaryKey = static::getPrimaryKey();

      // If the primary key is empty, then do an insert
      
      if (empty($this->$primaryKey)) {
        $params = array();
        foreach ($fields as $i => $field) {
            if ($field == $primaryKey)
                unset($fields[$i]);
        }

        $fieldSql = implode(', ', $fields);

        $valueArray = array();
        foreach ($fields as $field) {
            $valueArray[] = ":$field";
            $params[$field] = $this->$field;
        }

        $valueSql = implode(', ', $valueArray);

        $sql = "insert into $table ($fieldSql) values ($valueSql)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $this->$primaryKey = $pdo->lastInsertId();
      }
      // If the primary key is not empty, then do an update
      else {
        $params = array();

        foreach ($fields as $i => $field) {
            if ($field == $primaryKey)
                unset($fields[$i]);
        }

        $fieldArray = array();
        foreach ($fields as $field){
            $fieldArray[] = "$field = :$field";
            $params[$field] = $this->$field;
        }

        $updateSql = implode(', ', $fieldArray);

        $params['primary_key'] = $this->$primaryKey;

        $sql = "update $table set $updateSql where $primaryKey = :primary_key";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
      }

    }

}