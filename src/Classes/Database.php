<?php
    define('USER', 'db_school');
    define('PASSWORD', 'VYtJXrkKTwVqxX6u');
    define('DSN', 'mysql:host=localhost;dbname=school');

    class Database
    {
        private static function connect()
        {
            try
            {
                return new PDO(DSN, USER, PASSWORD);
            }
            catch (Exception $e)
            {
                echo "Error: " . $e->getMessage();
            }
        }

        public static function query($query, $params = array())
        {
            $pdo = self::connect();
            $statement = $pdo->prepare($query);
            $statement->execute($params);

            if (explode(' ', $query)[0] == 'SELECT')
            {
                $data = $statement -> fetchAll();
                return $data;
            }

            if (explode(' ', $query)[0] == 'INSERT')
            {
                return $pdo->lastInsertId();
            }
        }
    }