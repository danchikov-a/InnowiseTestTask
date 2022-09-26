<?php

namespace src;

require $_SERVER['DOCUMENT_ROOT'] . "/app/models/IUser.php";
require $_SERVER['DOCUMENT_ROOT'] . "/app/enums/Gender.php";
require $_SERVER['DOCUMENT_ROOT'] . "/app/enums/Status.php";
require $_SERVER['DOCUMENT_ROOT'] . "/app/models/Model.php";

class User extends Model implements IUser
{
    public function __construct(private string $name,
        private string $email,
        private Gender $gender,
        private Status $status
    ){}

    public static function save(User $user): bool
    {
        $conn = static::getDB();

        $email = $user->getEmail();

        if ($conn->query("SELECT * FROM Users WHERE Email = '$email'")->rowCount() == 0) {
            $name = $user->getName();
            $gender = $user->getGender()->value;
            $status = $user->getStatus()->value;

            $conn->query("INSERT INTO Users(Email, Name, Gender, Status) VALUES ('$email', '$name', '$gender', '$status')");

            return true;
        } else {
            return false;
        }
    }

    public static function delete(string $email)
    {
        $conn = static::getDB();

        $conn->query("DELETE FROM Users WHERE Email = '$email'");
    }

    public static function update(string $oldEmail, User $user): bool
    {
        $conn = static::getDB();

        $name = $user->getName();
        $email = $user->getEmail();
        $gender = $user->getGender()->value;
        $status = $user->getStatus()->value;

        if ($conn->query("SELECT * FROM Users WHERE Email = '$email'")->rowCount() == 0) {
            $conn->query("UPDATE Users SET Email = '$email', Name = '$name', Gender = '$gender', Status = '$status' WHERE Email = '$oldEmail'");

            return true;
        } else {
            return false;
        }
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