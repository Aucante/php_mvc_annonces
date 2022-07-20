<?php

namespace App\Models;

class UsersModel extends Model
{
    protected int $id;
    protected string $email;
    protected string $password;

    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }


    /**
     * Select user from his mail
     * @param string $email
     * @return false|\PDOStatement
     */
    public function findOneByEmail(string $email)
    {
        return $this->req("SELECT * FROM {$this->table} WHERE email = ?", [$email])->fetch();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


}
