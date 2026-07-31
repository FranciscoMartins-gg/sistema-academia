<?php

namespace Config;

use PDO;
use PDOException;


class Database{

    private static ?PDO $pdo = null;


    public function __construct()
    {
    }

    public static function  getConnection(): PDO{
        
        if(self::$pdo === null){
        
            $host = $_ENV["MYSQL_HOST"];
            $user = $_ENV["MYSQL_USER"];
            $password = $_ENV["MYSLQ_PASSWORD"];
            $dbname = $_ENV["MYSQL_DATABASE"];
            $dsn = "myslq:host=$host;dbname=$dbname;charset=ut8mb4";
        
            try {

                self::$pdo =  new PDO($dsn, $user, $password);

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {

                die("Erro na Conexão" . $e->getMessage());
            
            }
        }
            return self::$pdo;
    }

 }