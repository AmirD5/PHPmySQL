<?php


//Database creation class,created it in a different file so the others wont be so clutterd
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public $conn;

    public function __construct($servername,$username,$password,$dbname){
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->conn = new mysqli($servername,$username,$password,$dbname);

        if($this->conn->connect_error)
        {
            die("Connection failed" .$this->conn->connect_error);
        }
    }

    public function select($sql)
    {
        $result = $this->conn->query($sql);
        if(!$result)
        {
            die("Query failed" .$this->conn->error);
        }
        $data = array();
        while($row = $result->fetch_assoc())
        {
            $data[] = $row;
        }
        return $data;

    }

    public function insert($sql)
    {
        if($this->conn->query($sql) === TRUE)
        {
            return true;
        }
        else
        {
            die("Query failed" .$this->conn->error);
        }
    }

    public function delete($sql)
    {
        if ($this->conn->query($sql) === TRUE)
        {
            return true;
        } else {
            die("Error: " . $sql . "<br>" . $this->conn->error);
        }
    }

    public function update($sql)
    {
        if ($this->conn->query($sql) === TRUE)
        {
            return true;
        } else
        {
            die("Error: " . $sql . "<br>" . $this->conn->error);
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }


}