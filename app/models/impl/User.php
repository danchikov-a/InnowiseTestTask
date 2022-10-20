<?php

namespace App\Models\Impl;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\BaseModel;

class User extends BaseModel
{
    public function __construct(private string $name, private string $email,
                                private Gender $gender, private Status $status, private string $password)
    {
        parent::__construct();

        $this->table = "Users";
        $this->className = __CLASS__;

        $this->fields["Name"] = $this->name;
        $this->fields["Email"] = $this->email;
        $this->fields["Gender"] = $this->gender->value;
        $this->fields["Status"] = $this->status->value;
        $this->fields["Password"] = md5($this->password);
    }

    public function checkUser(): bool
    {
        $selectStatement = $this->conn->prepare("SELECT * FROM Users WHERE Email = :email AND Name = :name AND Password = :password");
        $selectStatement->execute(['email' => $this->email, 'name' => $this->name, 'password' => md5($this->password)]);

        return $selectStatement->rowCount() == 1;
    }

    public function getIdByEmail(string $email): int
    {
        $selectStatement = $this->conn->prepare("SELECT Id FROM Users WHERE Email = :email");
        $selectStatement->execute(['email' => $this->email]);

        return $selectStatement->fetch()["Id"];
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}