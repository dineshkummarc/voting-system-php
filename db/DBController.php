<?php
class DBController
{
    protected $host = 'localhost';
    protected $user = 'root';
    protected $password = '';
    protected $database = 'votyy';
    public $con = null;

    public function __construct()
    {
        $this->con = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->con->connect_error) {
            echo 'db connection failed';
        }
    }

    public function __destruct()
    {
        //we have a connection
        if ($this->con != null) {
            $this->con->close();
            $this->con = null;
        }
    }
}
