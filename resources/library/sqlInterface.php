<?php
/*
* Generic Class for interfacing directly with an SQL based database. A wrapper
* class for functions available for PostgreSQL in default PHP. Enforces platform
* independence as functions can be modified to suit any database type.
*
* Rev 1.0 - Joshua Gray
*/

  class SqlInterface{
    private $_conn;
    private $_dbHost;
    private $_dbName;
    private $_dbUser;
    private $_dbPass;

    public $queryData;

    function __construct($dbHost, $dbName, $dbUser, $dbPass)
    {
      $this->_dbHost = $dbHost;
      $this->_dbName = $dbName;
      $this->_dbUser = $dbUser;
      $this->_dbPass = $dbPass;

    }

    public function connect()
    {
      $this->_conn = pg_connect("host=" . $this->_dbHost . " dbname=" . $this->_dbName . " user=" . $this->_dbUser . " password =" . $this->_dbPass);
    }

    public function close()
    {
      pg_close($this->_conn);
    }

    function query($queryString)
    {
      $this->queryData = pg_query($this->_conn, $queryString);
    }

    function queryParams(string $query, array $params)
    {
      $this->queryData = pg_query_params($this->_conn, $query, $params);
    }
  }
