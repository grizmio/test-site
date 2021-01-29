<?php

namespace Libs;

// Debe ser singleton
class Database {
    private static string $dsn;
    private static string $user;
    private static string $password;
    private static $options = null;
    private static \PDO $pdoConnection;

    public static function setUser($user) : Database {
        self::$user = $user;
        return new static;
    }

    public static function setOptions($options) : Database {
        self::$options = $options;
        return new static;
    }

    public static function setPassword($password) : Database {
        self::$password = $password;
        return new static;
    }

    public static function setDsn($dsn) : Database {
        self::$dsn = $dsn;
        return new static;
    }

    public static function getDsn() : string {
        return self::$dsn;
    }

    // Puede lanzar: PDOException
    public static function connect() : Database {
        self::$pdoConnection = new \PDO(self::$dsn, self::$user, self::$password, self::$options);
        return new static;
    }

    public static function findAllAsObjects(string $className, string $query, array $values = [], array $driverOptions = []) {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        if($st===false){
            throw new \Exception(self::$pdoConnection->errorInfo()[2]);
        }
        $st->execute($values);
        return $st->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function findAll(string $query, array $values = [], array $driverOptions = []) {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        if($st===false){
            throw new \Exception(self::$pdoConnection->errorInfo()[2]);
        }
        $st->execute($values);
        return $st->fetchAll();
    }

    public static function findFirstAsObject(string $className, string $query, array $values = [], array $driverOptions = []) {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        $st->setFetchMode(\PDO::FETCH_CLASS, $className);
        $st->execute($values);
        return $st->fetch();
    }

    public static function findFirst(string $query, array $values = [], array $driverOptions = []) {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        if($st===false){
            throw new \Exception(self::$pdoConnection->errorInfo()[2]);
        }
        $st->execute($values);
        return $st->fetch();
    }

    public static function delete(string $query, array $values = [], array $driverOptions = []) : int {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        if($st===false){
            throw new \Exception(self::$pdoConnection->errorInfo()[2]);
        }
        $st->execute($values);
        return $st->rowCount();
    }

    public static function insert(string $query, array $values = [], array $driverOptions = []) : int {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        $st->execute($values);
        return self::$pdoConnection->lastInsertId();
    }

    public static function update(string $query, array $values = [], array $driverOptions = []) : int {
        $st = self::$pdoConnection->prepare($query, $driverOptions);
        $st->execute($values);
        return $st->rowCount();
    }
}
