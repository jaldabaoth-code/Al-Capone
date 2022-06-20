<?php

require_once '../connec.php';

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO(DSN, USER, PASS);
    }

    public function readBribes(): array
    {
        $query = 'SELECT * FROM bribe ORDER BY name ASC';
        $statement = $this->pdo->query($query);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function addBribe(array $form): void
    {
        $query = 'INSERT INTO bribe (name, payment) VALUES (:name, :payment)';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $form['name'], PDO::PARAM_STR);
        $statement->bindValue(':payment', $form['payment'], PDO::PARAM_INT);
        $statement->execute();
    }

    public function readByLetter (string $letter): array
    {
        $query = 'SELECT * FROM bribe WHERE name LIKE :letter ORDER BY name ASC';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':letter', $letter . '%', PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}
