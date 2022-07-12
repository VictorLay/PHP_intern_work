<?php
require_once "./bean/Entity.php";

class User extends Entity
{
    private int $id;
    private string $email;
    private string $name;
    private string $country;
    private string $role;
    private string $avatar_path;

    public function __construct()
    {
        $this->id = -1;
    }

    /**
     * @return string
     */
    public function getAvatarPath(): string
    {
        return $this->avatar_path;
    }

    /**
     * @param string $avatar_path
     */
    public function setAvatarPath(string $avatar_path): void
    {
        $this->avatar_path = $avatar_path;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }



    public function __toString()
    {
        return "<td>" . $this->id . "</td>" .
            "<td>" . $this->email . "</td>" .
            "<td>" . $this->country . "</td>" .
            "<td>" . $this->name . "</td>".
            "<td>" . $this->role . "</td>";

    }


}