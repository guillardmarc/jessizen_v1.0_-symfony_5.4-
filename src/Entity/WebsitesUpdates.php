<?php

namespace App\Entity;

use App\Repository\WebsitesUpdatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WebsitesUpdatesRepository::class)
 */
class WebsitesUpdates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInfo;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $underVersion;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="websitesUpdatesAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Websites::class, inversedBy="websitesUpdates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $website;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(?string $moreInfo): self
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    public function getUnderVersion(): ?string
    {
        return $this->underVersion;
    }

    public function setUnderVersion(?string $underVersion): self
    {
        $this->underVersion = $underVersion;

        return $this;
    }

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getWebsite(): ?Websites
    {
        return $this->website;
    }

    public function setWebsite(?Websites $website): self
    {
        $this->website = $website;

        return $this;
    }
}
