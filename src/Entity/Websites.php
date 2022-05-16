<?php

namespace App\Entity;

use App\Repository\WebsitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WebsitesRepository::class)
 */
class Websites
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
    private $logoText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoPictureAlt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoPictureLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoPictureName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $copyright;

    /**
     * @ORM\Column(type="text")
     */
    private $regulation;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $version;

    /**
     * @ORM\Column(type="text")
     */
    private $presentationText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentationPictureAlt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentationPictureLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $presentationPictureName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="websitesAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="websitesDevelopper")
     * @ORM\JoinColumn(nullable=false)
     */
    private $developper;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="websitesOwner")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=WebsitesUpdates::class, mappedBy="website", orphanRemoval=true)
     */
    private $websitesUpdates;

    public function __construct()
    {
        $this->websitesUpdates = new ArrayCollection();
    }

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

    public function getLogoText(): ?string
    {
        return $this->logoText;
    }

    public function setLogoText(string $logoText): self
    {
        $this->logoText = $logoText;

        return $this;
    }

    public function getLogoPictureAlt(): ?string
    {
        return $this->logoPictureAlt;
    }

    public function setLogoPictureAlt(?string $logoPictureAlt): self
    {
        $this->logoPictureAlt = $logoPictureAlt;

        return $this;
    }

    public function getLogoPictureLink(): ?string
    {
        return $this->logoPictureLink;
    }

    public function setLogoPictureLink(?string $logoPictureLink): self
    {
        $this->logoPictureLink = $logoPictureLink;

        return $this;
    }

    public function getLogoPictureName(): ?string
    {
        return $this->logoPictureName;
    }

    public function setLogoPictureName(?string $logoPictureName): self
    {
        $this->logoPictureName = $logoPictureName;

        return $this;
    }

    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    public function setCopyright(string $copyright): self
    {
        $this->copyright = $copyright;

        return $this;
    }

    public function getRegulation(): ?string
    {
        return $this->regulation;
    }

    public function setRegulation(string $regulation): self
    {
        $this->regulation = $regulation;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getPresentationText(): ?string
    {
        return $this->presentationText;
    }

    public function setPresentationText(string $presentationText): self
    {
        $this->presentationText = $presentationText;

        return $this;
    }

    public function getPresentationPictureAlt(): ?string
    {
        return $this->presentationPictureAlt;
    }

    public function setPresentationPictureAlt(string $presentationPictureAlt): self
    {
        $this->presentationPictureAlt = $presentationPictureAlt;

        return $this;
    }

    public function getPresentationPictureLink(): ?string
    {
        return $this->presentationPictureLink;
    }

    public function setPresentationPictureLink(string $presentationPictureLink): self
    {
        $this->presentationPictureLink = $presentationPictureLink;

        return $this;
    }

    public function getPresentationPictureName(): ?string
    {
        return $this->presentationPictureName;
    }

    public function setPresentationPictureName(string $presentationPictureName): self
    {
        $this->presentationPictureName = $presentationPictureName;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

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

    public function getDevelopper(): ?Users
    {
        return $this->developper;
    }

    public function setDevelopper(?Users $developper): self
    {
        $this->developper = $developper;

        return $this;
    }

    public function getOwner(): ?Users
    {
        return $this->owner;
    }

    public function setOwner(?Users $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, WebsitesUpdates>
     */
    public function getWebsitesUpdates(): Collection
    {
        return $this->websitesUpdates;
    }

    public function addWebsitesUpdate(WebsitesUpdates $websitesUpdate): self
    {
        if (!$this->websitesUpdates->contains($websitesUpdate)) {
            $this->websitesUpdates[] = $websitesUpdate;
            $websitesUpdate->setWebsite($this);
        }

        return $this;
    }

    public function removeWebsitesUpdate(WebsitesUpdates $websitesUpdate): self
    {
        if ($this->websitesUpdates->removeElement($websitesUpdate)) {
            // set the owning side to null (unless already changed)
            if ($websitesUpdate->getWebsite() === $this) {
                $websitesUpdate->setWebsite(null);
            }
        }

        return $this;
    }
}
