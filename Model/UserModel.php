<?php

namespace Model;

use Libs\Database;
use Libs\PasswordHasherHelper;
use Entity\User;
use Libs\ShortPasswordException;

class UserModel {
    private string $table = 'users';
    private string $entity = User::class;

    public function findById(int $id) : ?User {
        $query = 'SELECT * FROM '.$this->table.' WHERE id = ?';
        $result = Database::findFirstAsObject($this->entity, $query, [$id]);
        if($result === false){
            $result = null;
        }
        return $result;
    }

    public function findBy(string $field, $value) : ?User {
        $query = 'SELECT * FROM '.$this->table.' WHERE '.$field.' = ?';
        $result = Database::findFirstAsObject($this->entity, $query, [$value]);
        if($result === false){
            $result = null;
        }
        return $result;
    }

    public function findAllUsers() {
        $query = 'SELECT * FROM '.$this->table.' ORDER BY id ASC';
        return Database::findAllAsObjects($this->entity, $query);
    }

    public function deleteUserById(int $id) : int {
        if(!empty($id)) {
            $query = 'DELETE FROM '.$this->table.' WHERE id = ?';
            return Database::delete($query, [$id]);
        }else{
            throw new \Exception("Parameter \"id\" esta vacio (empty()): $id");
        }
    }

    public function saveNewUser(User $user) : int {
        if(strlen($user->getPassword()) < PASSWORD_MIN_LENGTH){
            throw new ShortPasswordException("Minimum password length: ".PASSWORD_MIN_LENGTH);
        }
        $hashedPassword = PasswordHasherHelper::hash($user->getPassword());
        $values = [$user->getName(), $user->getLastName(), $user->getEmail(), $hashedPassword];
        $query = 'INSERT INTO '.$this->table.' (name,lastname,email,password) values (?,?,?,?)';
        return Database::insert($query, $values);
    }

    public function updateUser(User $user) : int {
        if(strlen($user->getPassword()) < PASSWORD_MIN_LENGTH){
            throw new ShortPasswordException("Minimum password length: ".PASSWORD_MIN_LENGTH);
        }
        $hashedPassword = PasswordHasherHelper::hash($user->getPassword());
        $values = [$user->getName(), $user->getLastName(), $user->getEmail(), $hashedPassword, $user->getId()];
        $query = 'UPDATE '.$this->table.' SET name=?, lastname=?, email=?, password=?, updated=NOW() WHERE id = ?';
        return Database::update($query, $values);
    }

    public function updateLoginTimeStamp(int $userId) {
        $query = 'UPDATE '.$this->table.' u1 JOIN '.$this->table.' u2 ON u1.id = u2.id SET u1.prevlogintimestamp=u2.logintimestamp WHERE u1.id = ?';

        $rows = Database::update($query, [$userId]);
        if($rows !== 1) {
            return $rows;
        }
        $query = 'UPDATE '.$this->table.' SET logintimestamp=NOW() WHERE id = ?';
        return Database::update($query, [$userId]);
    }

}
