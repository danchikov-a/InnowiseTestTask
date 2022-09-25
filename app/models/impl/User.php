<?php

namespace src;

use PDO;

require_once "app/models/IUser.php";
require_once "app/enums/Gender.php";
require_once "app/enums/Status.php";

class User implements IUser
{
    private string $name;
    private string $email;
    private Gender $gender;
    private Status $status;

    private array $users = [];

    private const DB_HOST = 'myapp.cfg.DB_HOST';
    private const DB_USER = 'myapp.cfg.DB_USER';
    private const DB_PASS = 'myapp.cfg.DB_PASS';
    private const CONFIG_PATH = 'app/config/php.ini';

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    public function deleteUser(string $email)
    {
        // TODO: Implement deleteUser() method.
    }

    public function editUser(string $email)
    {
        // TODO: Implement editUser() method.
    }

    public function getUsers(): array
    {
        $credentials = parse_ini_file(self::CONFIG_PATH);
        $conn = new PDO($credentials[self::DB_HOST], $credentials[self::DB_USER], $credentials[self::DB_PASS]);
        $users = $conn->query("SELECT * from Users");

        while ($row = $users->fetchObject(__CLASS__)) {
            $this->users[] = $row;
        }

        return $this->users;
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