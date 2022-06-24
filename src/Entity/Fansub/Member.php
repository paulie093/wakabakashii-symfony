<?php

namespace App\Entity\Fansub;

use App\Repository\Fansub\MemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nickname;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fansubTeam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getFansubTeam(): ?Team
    {
        return $this->fansubTeam;
    }

    public function setFansubTeam(?Team $fansubTeam): self
    {
        $this->fansubTeam = $fansubTeam;

        return $this;
    }

    public function __toString()
    {
        return $this->getNickname();
    }
}
