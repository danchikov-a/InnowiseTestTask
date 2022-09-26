<?php

namespace src;

use PDO;

require $_SERVER['DOCUMENT_ROOT'] . "/app/models/IUser.php";
require $_SERVER['DOCUMENT_ROOT'] . "/app/enums/Gender.php";
require $_SERVER['DOCUMENT_ROOT'] . "/app/enums/Status.php";

class User implements IUser
{
    private string $name;
    private string $email;
    private Gender $gender;
    private Status $status;

    private const DB_HOST = 'myapp.cfg.DB_HOST';
    private const DB_USER = 'myapp.cfg.DB_USER';
    private const DB_PASS = 'myapp.cfg.DB_PASS';
    private const CONFIG_PATH = '/app/config/php.ini';

    /**
     * @param string $name
     * @param string $email
     * @param Gender $gender
     * @param Status $status
     */
    public function __construct(string $name, string $email, Gender $gender, Status $status)
    {
        $this->name = $name;
        $this->email = $email;
        $this->gender = $gender;
        $this->status = $status;
    }

    public static function save(User $user): bool
    {
        $credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH);
        $conn = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);

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
        $credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH);
        $conn = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);

        $conn->query("DELETE FROM Users WHERE Email = '$email'");
    }

    public static function update(string $oldEmail, User $user): bool
    {
        $credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH);
        $conn = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);

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
        $credentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH);
        $conn = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);

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