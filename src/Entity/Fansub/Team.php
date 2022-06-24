<?php

namespace App\Entity\Fansub;

use App\Entity\Project\Project;
use App\Repository\Fansub\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $websiteUrl;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, mappedBy="fansubTeam")
     */
    private $relatedProjects;

    public function __construct()
    {
        $this->relatedProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getRelatedProjects(): Collection
    {
        return $this->relatedProjects;
    }

    public function addRelatedProject(Project $relatedProject): self
    {
        if (!$this->relatedProjects->contains($relatedProject)) {
            $this->relatedProjects[] = $relatedProject;
            $relatedProject->addFansubTeam($this);
        }

        return $this;
    }

    public function removeRelatedProject(Project $relatedProject): self
    {
        if ($this->relatedProjects->removeElement($relatedProject)) {
            $relatedProject->removeFansubTeam($this);
        }

        return $this;
    }

    public function __toString()
    {
        return "{$this->getName()} ({$this->getShortName()})";
    }
}
