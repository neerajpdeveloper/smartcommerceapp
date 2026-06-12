<?php

class Config
{
    private static $conn = null;

    protected $server   = 'localhost';
    protected $database = 'smartcommerceapp';
    protected $username = 'root';
    protected $password = '';

    public function db()
    {
        if(self::$conn === null)
        {
            try{

                self::$conn = new PDO(
                    "mysql:host={$this->server};dbname={$this->database};charset=utf8mb4",
                    $this->username,
                    $this->password
                );

                self::$conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

            }catch(PDOException $e){

                die($e->getMessage());

            }
        }

        return self::$conn;
    }
}