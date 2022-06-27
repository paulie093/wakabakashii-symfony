<?php

namespace App\Entity\Project;

use App\Entity\Fansub\Member;
use App\Entity\Fansub\Team;
use App\Repository\Project\ProjectRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $titleJap;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $token;

    /**
     * @ORM\Column(type="integer")
     */
    private $startYear;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $endYear;

    /**
     * @ORM\Column(type="integer")
     */
    private $episodeNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $officialSiteUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $animeNewsNetworkId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $aniDbId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $myAnimeListId;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $releaseResolution;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectVideoQuality::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectVideoQuality;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectStatus::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectStatus;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectType::class, inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectType;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="relatedProjects")
     */
    private $fansubTeam;

    /**
     * @ORM\OneToMany(targetEntity=Episode::class, mappedBy="project")
     */
    private $episodes;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $coverImage;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->fansubTeam = new ArrayCollection();
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitleJap(): ?string
    {
        return $this->titleJap;
    }

    public function setTitleJap(?string $titleJap): self
    {
        $this->titleJap = $titleJap;

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

    public function getStartYear(): ?int
    {
        return $this->startYear;
    }

    public function setStartYear(int $startYear): self
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getEndYear(): ?int
    {
        return $this->endYear;
    }

    public function setEndYear(int $endYear): self
    {
        $this->endYear = $endYear;

        return $this;
    }

    public function getEpisodeNumber(): ?int
    {
        return $this->episodeNumber;
    }

    public function setEpisodeNumber(int $episodeNumber): self
    {
        $this->episodeNumber = $episodeNumber;

        return $this;
    }

    public function getOfficialSiteUrl(): ?string
    {
        return $this->officialSiteUrl;
    }

    public function setOfficialSiteUrl(?string $officialSiteUrl): self
    {
        $this->officialSiteUrl = $officialSiteUrl;

        return $this;
    }

    public function getAnimeNewsNetworkId(): ?int
    {
        return $this->animeNewsNetworkId;
    }

    public function setAnimeNewsNetworkId(?int $animeNewsNetworkId): self
    {
        $this->animeNewsNetworkId = $animeNewsNetworkId;

        return $this;
    }

    public function getAniDbId(): ?int
    {
        return $this->aniDbId;
    }

    public function setAniDbId(?int $aniDbId): self
    {
        $this->aniDbId = $aniDbId;

        return $this;
    }

    public function getMyAnimeListId(): ?int
    {
        return $this->myAnimeListId;
    }

    public function setMyAnimeListId(?int $myAnimeListId): self
    {
        $this->myAnimeListId = $myAnimeListId;

        return $this;
    }

    public function getReleaseResolution(): ?string
    {
        return $this->releaseResolution;
    }

    public function setReleaseResolution(string $releaseResolution): self
    {
        $this->releaseResolution = $releaseResolution;

        return $this;
    }

    public function getProjectVideoQuality(): ?ProjectVideoQuality
    {
        return $this->projectVideoQuality;
    }

    public function setProjectVideoQuality(?ProjectVideoQuality $projectVideoQuality): self
    {
        $this->projectVideoQuality = $projectVideoQuality;

        return $this;
    }

    public function getProjectStatus(): ?ProjectStatus
    {
        return $this->projectStatus;
    }

    public function setProjectStatus(?ProjectStatus $projectStatus): self
    {
        $this->projectStatus = $projectStatus;

        return $this;
    }

    public function getProjectType(): ?ProjectType
    {
        return $this->projectType;
    }

    public function setProjectType(?ProjectType $projectType): self
    {
        $this->projectType = $projectType;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getFansubTeam(): Collection
    {
        return $this->fansubTeam;
    }

    public function addFansubTeam(Team $fansubTeam): self
    {
        if (!$this->fansubTeam->contains($fansubTeam)) {
            $this->fansubTeam[] = $fansubTeam;
        }

        return $this;
    }

    public function removeFansubTeam(Team $fansubTeam): self
    {
        $this->fansubTeam->removeElement($fansubTeam);

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setProject($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getProject() === $this) {
                $episode->setProject(null);
            }
        }

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage($coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
