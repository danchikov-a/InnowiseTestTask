<?php

namespace Tests\Models;
include __DIR__ . "/../../config/config.php";

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\Impl\User;
use PDO;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private const DB_HOST = 'host';
    private const DB_USER = 'user';
    private const DB_PASS = 'password';
    private const DB_CONFIG = 'db';
    private const CONFIG_PATH = '/config/config.php';

    private PDO $db;

    public function setUp(): void
    {
        $config = require $_SERVER['DOCUMENT_ROOT'] . self::CONFIG_PATH;

        $this->db = new PDO($config[self::DB_CONFIG][self::DB_HOST],
            $config[self::DB_CONFIG][self::DB_USER],
            $config[self::DB_CONFIG][self::DB_PASS]
        );

        $this->db->query("TRUNCATE TABLE Users");
    }

    public function testSaveValid()
    {
        $isSaved = User::save(new User("q", "q@gmail.com", Gender::MALE, Status::ACTIVE));

        self::assertTrue($isSaved);
    }

    public function testSaveUserWithSameEmail()
    {
        User::save(new User("q", "q@gmail.com", Gender::MALE, Status::ACTIVE));
        $isSaved = User::save(new User("q", "q@gmail.com", Gender::MALE, Status::ACTIVE));

        self::assertFalse($isSaved);
    }

    public function testDelete()
    {
        $email = "q@gmail.com";

        User::save(new User("q", $email, Gender::MALE, Status::ACTIVE));
        User::delete($email);
        $rowCount = $this->db->query("SELECT * FROM Users")->rowCount();

        self::assertSame($rowCount, 0);
    }

    public function testUpdateValid()
    {
        $oldEmail = "q@gmail.com";
        $newEmail = "qw@gmail.com";

        User::save(new User("q", $oldEmail, Gender::MALE, Status::ACTIVE));
        $isUpdated = User::update($oldEmail, new User("q", $newEmail, Gender::MALE, Status::ACTIVE));
        $rowCount = $this->db->query("SELECT * FROM Users where Email = '$newEmail'")->rowCount();

        self::assertSame($rowCount, 1);
    }

    public function testUpdateWithSameEmail()
    {
        $oldEmail = "qw@gmail.com";
        $existingEmail = "q@gmail.com";

        User::save(new User("q", $existingEmail, Gender::MALE, Status::ACTIVE));
        User::save(new User("qw", $oldEmail, Gender::MALE, Status::ACTIVE));
        $isUpdated = User::update($oldEmail, new User("q", $existingEmail, Gender::MALE, Status::ACTIVE));

        self::assertFalse($isUpdated);
    }

    public function testGetUsers()
    {
        User::save(new User("q", "q@gmail.com", Gender::MALE, Status::ACTIVE));
        User::save(new User("qw", "qw@gmail.com", Gender::MALE, Status::ACTIVE));
        $userCount = count(User::getUsers());

        self::assertSame($userCount, 2);
    }
}