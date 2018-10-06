<?php

namespace App\Parser;

/**
 * @author Afanasyev Pavel <bupyc9@gmail.com>
 */
class Item
{
    /** @var string */
    private $ipAddress;

    /** @var int */
    private $port;

    /** @var string */
    private $protocol;

    /** @var string */
    private $country;

    /** @var int */
    private $anonymity;

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    public function setProtocol(string $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAnonymity(): ?int
    {
        return $this->anonymity;
    }

    public function setAnonymity(int $anonymity): self
    {
        $this->anonymity = $anonymity;

        return $this;
    }
}