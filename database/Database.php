<?php

namespace database;

use PDO;
use PDOException;
use PDOStatement;
use ValueError;

class Database
{
    protected PDO $connection;

    function __construct()
    {
        try {
            $this->connection = new PDO(
                dsn: "mysql:host=" . DB_HOST
                    . ';dbname=' . DB_NAME
                    . ';charset=' . DB_CHARSET,
                username: DB_USERNAME,
                password: DB_PASSWORD,
                options: DB_OPTIONS
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function select(string $sql, ?array $values = null): PDOStatement|bool
    {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute($values);

            return $statement;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insert(
        string $tableName,
        array $fields,
        array $values
    ): bool {
        $sql = "INSERT INTO $tableName ("
            . implode(',', $fields) . ',created_at'
            . ') VALUES(:'
            . implode(',:', $fields) . ',NOW()'
            . ");";

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute(array_combine($fields, $values));

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update(
        string $tableName,
        int $id,
        array $fields,
        array $values
    ): bool {
        $sql = "UPDATE $tableName SET ";

        foreach (array_combine($fields, $values) as $field => $value) {
            if ($value) {
                $sql .= $field . '=?, ';
            } else {
                $sql .= $field . '=NULL, ';
            }
        }

        $sql .= 'updated_at=NOW() WHERE id=?;';

        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute(
                array_merge(
                    array_filter(array_values($values)),
                    [$id]
                )
            );

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete(
        string $tableName,
        int $id
    ): bool {
        try {
            $sql = "DELETE FROM $tableName WHERE id=?;";
            $statement = $this->connection->prepare($sql);
            $statement->execute([$id]);

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
