<?php

namespace App\Models\Impl;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\IUser;
use App\Models\Model;

class User extends Model implements IUser
{
    public function __construct(private string $name, private string $email, private Gender $gender, private Status $status)
    {
    }

    public static function save(User $user): bool
    {
        $conn = static::getDB();

        $email = $user->getEmail();
        $selectStatement = $conn->prepare("SELECT * FROM Users WHERE Email = :email");
        $selectStatement->execute(['email' => $email]);

        $rowsAmount = $selectStatement->rowCount();

        if ($rowsAmount == 0) {
            $name = $user->getName();
            $gender = $user->getGender()->value;
            $status = $user->getStatus()->value;

            $insertStatement = $conn->prepare("INSERT INTO Users(Email, Name, Gender, Status)
                                                            VALUES (:email, :name, :gender, :status)");
            $insertStatement->execute(['email' => $email, 'name' => $name, 'gender' => $gender, 'status' => $status]);

            return true;
        } else {
            return false;
        }
    }

    public static function update(string $oldEmail, User $user): bool
    {
        $conn = static::getDB();

        $email = $user->getEmail();
        $selectStatement = $conn->prepare("SELECT * FROM Users WHERE Email = :email");
        $rowsAmount = $selectStatement->rowCount();

        if ($rowsAmount == 0) {
            $selectStatement->execute(['email' => $email]);
            $name = $user->getName();
            $gender = $user->getGender()->value;
            $status = $user->getStatus()->value;

            $insertStatement = $conn->prepare("UPDATE Users 
                    SET Email = :email, Name = :name, Gender = :gender, Status = :status WHERE Email = :oldEmail");
            $insertStatement->execute(['email' => $email, 'name' => $name,
                'gender' => $gender, 'status' => $status, 'oldEmail' => $oldEmail]);

            return true;
        } else {
            return false;
        }
    }

    public static function delete(string $email): bool
    {
        $conn = static::getDB();

        $deleteStatement = $conn->prepare("DELETE FROM Users WHERE Email = :email");
        $deleteStatement->execute(['email' => $email]);

        return $deleteStatement->rowCount() > 0;
    }

    public static function getUsers(): array
    {
        $conn = static::getDB();

        $userList = [];
        $users = $conn->query("SELECT * from Users");

        while ($row = $users->fetchObject(__CLASS__, ['email', 'name', GENDER::MALE, STATUS::ACTIVE])) {
            $userList[] = $row;
        }

        return $userList;
    }

    public static function getUser(string $email): User|false
    {
        $conn = static::getDB();

        $selectStatement = $conn->prepare("SELECT * FROM Users WHERE Email = :email");
        $selectStatement->execute(['email' => $email]);
        $obj = $selectStatement->fetchObject(__CLASS__, ['email', 'name', GENDER::MALE, STATUS::ACTIVE]);

        if ($selectStatement->rowCount() == 1) {
            return $obj;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->gender;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param Gender $gender
     */
    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

}