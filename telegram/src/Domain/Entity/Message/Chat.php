<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Chat
{
    #[SerializedName("id")]
    private int $id;

    #[SerializedName("first_name")]
    private string $firstName;

    #[SerializedName("username")]
    private string $username;

    #[SerializedName("type")]
    private string $type;

    /**
     * @param int $id
     * @param string $firstName
     * @param string $username
     * @param string $type
     */
    public function __construct(int $id, string $firstName, string $username, string $type)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->username = $username;
        $this->type = $type;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getType(): string
    {
        return $this->type;
    }

}