<?php

class db
{
    private $dbhost = "localhost";
    private $dbuser = "root";
    private $dbpass = "";
    private $dbname = "server";
    private $charset = 'utf8';

    function connect()
    {

        $mysql_conn_string = "mysql:host=$this->dbhost;dbname=$this->dbname;charset=$this->charset";
        $db_conn = new PDO($mysql_conn_string, $this->dbuser, $this->dbpass);
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db_conn;
    }
}
