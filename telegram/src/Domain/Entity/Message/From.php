<?php

namespace App\Domain\Entity\Message;

use Symfony\Component\Serializer\Annotation\SerializedName;

class From
{
    #[SerializedName("id")]
    private int $id;

    #[SerializedName("is_bot")]
    private bool $isBot;

    #[SerializedName("first_name")]
    private string $firstName;

    #[SerializedName("username")]
    private string $username;

    #[SerializedName("language_code")]
    private string $languageCode;

    /**
     * @param int $id
     * @param bool $isBot
     * @param string $firstName
     * @param string $username
     * @param string $languageCode
     */
    public function __construct(int $id, bool $isBot, string $firstName , string $username = '' , string $languageCode = '')
    {
        $this->id = $id;
        $this->isBot = $isBot;
        $this->firstName = $firstName;
        $this->username = $username;
        $this->languageCode = $languageCode;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function isBot(): bool
    {
        return $this->isBot;
    }


    public function getFirstName(): string
    {
        return $this->firstName;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

}