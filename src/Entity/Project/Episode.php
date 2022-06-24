<?php

namespace App\Entity\Project;

use App\Repository\Project\EpisodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 */
class Episode
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $titleJapRomaji;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $titleJapKanji;

    /**
     * @ORM\Column(type="integer")
     */
    private $episodeNumber;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $uploadDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $downloadUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $onlineEmbedId;

    /**
     * @ORM\ManyToOne(targetEntity=OnlineHost::class)
     */
    private $onlineHost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnailUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
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

    public function getTitleJapRomaji(): ?string
    {
        return $this->titleJapRomaji;
    }

    public function setTitleJapRomaji(string $titleJapRomaji): self
    {
        $this->titleJapRomaji = $titleJapRomaji;

        return $this;
    }

    public function getTitleJapKanji(): ?string
    {
        return $this->titleJapKanji;
    }

    public function setTitleJapKanji(string $titleJapKanji): self
    {
        $this->titleJapKanji = $titleJapKanji;

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

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(?\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }

    public function getDownloadUrl(): ?string
    {
        return $this->downloadUrl;
    }

    public function setDownloadUrl(?string $downloadUrl): self
    {
        $this->downloadUrl = $downloadUrl;

        return $this;
    }

    public function getOnlineEmbedId(): ?string
    {
        return $this->onlineEmbedId;
    }

    public function setOnlineEmbedId(?string $onlineEmbedId): self
    {
        $this->onlineEmbedId = $onlineEmbedId;

        return $this;
    }

    public function getOnlineHost(): ?OnlineHost
    {
        return $this->onlineHost;
    }

    public function setOnlineHost(?OnlineHost $onlineHost): self
    {
        $this->onlineHost = $onlineHost;

        return $this;
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnailUrl;
    }

    public function setThumbnailUrl(?string $thumbnailUrl): self
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }
}
