<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_BANNED = 'ROLE_BANNED';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_AUTHOR = 'ROLE_AUTHOR';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureProfilAlt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureProfilLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureProfilName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInfo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $websiteSettlementAccept;

    /**
     * @ORM\OneToMany(targetEntity=UsersLinks::class, mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $usersLinks;

    /**
     * @ORM\OneToMany(targetEntity=Websites::class, mappedBy="author", orphanRemoval=true)
     */
    private $websitesAuthor;

    /**
     * @ORM\OneToMany(targetEntity=Websites::class, mappedBy="developper")
     */
    private $websitesDevelopper;

    /**
     * @ORM\OneToMany(targetEntity=Websites::class, mappedBy="owner")
     */
    private $websitesOwner;

    /**
     * @ORM\OneToMany(targetEntity=WebsitesUpdates::class, mappedBy="author")
     */
    private $websitesUpdatesAuthor;

    /**
     * @ORM\OneToMany(targetEntity=Categories::class, mappedBy="author", orphanRemoval=true)
     */
    private $categoriesAuthor;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="author", orphanRemoval=true)
     */
    private $articlesAuthor;

    /**
     * @ORM\ManyToMany(targetEntity=Articles::class, mappedBy="favories")
     */
    private $articlesFavories;

    /**
     * @ORM\OneToMany(targetEntity=ArticlesComments::class, mappedBy="author", orphanRemoval=true)
     */
    private $articlesCommentsAuthors;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, mappedBy="favories")
     */
    private $categoriesFavories;

    public function __construct()
    {
        $this->roles = [self::ROLE_USER];
        $this->usersLinks = new ArrayCollection();
        $this->websitesAuthor = new ArrayCollection();
        $this->websitesDevelopper = new ArrayCollection();
        $this->websitesOwner = new ArrayCollection();
        $this->websitesUpdatesAuthor = new ArrayCollection();
        $this->categoriesAuthor = new ArrayCollection();
        $this->articlesAuthor = new ArrayCollection();
        $this->articlesFavories = new ArrayCollection();
        $this->articlesCommentsAuthors = new ArrayCollection();
        $this->categoriesFavories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPictureProfilAlt(): ?string
    {
        return $this->pictureProfilAlt;
    }

    public function setPictureProfilAlt(?string $pictureProfilAlt): self
    {
        $this->pictureProfilAlt = $pictureProfilAlt;

        return $this;
    }

    public function getPictureProfilLink(): ?string
    {
        return $this->pictureProfilLink;
    }

    public function setPictureProfilLink(?string $pictureProfilLink): self
    {
        $this->pictureProfilLink = $pictureProfilLink;

        return $this;
    }

    public function getPictureProfilName(): ?string
    {
        return $this->pictureProfilName;
    }

    public function setPictureProfilName(?string $pictureProfilName): self
    {
        $this->pictureProfilName = $pictureProfilName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getWebsiteSettlementAccept(): ?bool
    {
        return $this->websiteSettlementAccept;
    }

    public function setWebsiteSettlementAccept(bool $websiteSettlementAccept): self
    {
        $this->websiteSettlementAccept = $websiteSettlementAccept;

        return $this;
    }

    /**
     * @return Collection<int, UsersLinks>
     */
    public function getUsersLinks(): Collection
    {
        return $this->usersLinks;
    }

    public function addUsersLink(UsersLinks $usersLink): self
    {
        if (!$this->usersLinks->contains($usersLink)) {
            $this->usersLinks[] = $usersLink;
            $usersLink->setUser($this);
        }

        return $this;
    }

    public function removeUsersLink(UsersLinks $usersLink): self
    {
        if ($this->usersLinks->removeElement($usersLink)) {
            // set the owning side to null (unless already changed)
            if ($usersLink->getUser() === $this) {
                $usersLink->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Websites>
     */
    public function getWebsitesAuthor(): Collection
    {
        return $this->websitesAuthor;
    }

    public function addWebsitesAuthor(Websites $websitesAuthor): self
    {
        if (!$this->websitesAuthor->contains($websitesAuthor)) {
            $this->websitesAuthor[] = $websitesAuthor;
            $websitesAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeWebsitesAuthor(Websites $websitesAuthor): self
    {
        if ($this->websitesAuthor->removeElement($websitesAuthor)) {
            // set the owning side to null (unless already changed)
            if ($websitesAuthor->getAuthor() === $this) {
                $websitesAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Websites>
     */
    public function getWebsitesDevelopper(): Collection
    {
        return $this->websitesDevelopper;
    }

    public function addWebsitesDevelopper(Websites $websitesDevelopper): self
    {
        if (!$this->websitesDevelopper->contains($websitesDevelopper)) {
            $this->websitesDevelopper[] = $websitesDevelopper;
            $websitesDevelopper->setDevelopper($this);
        }

        return $this;
    }

    public function removeWebsitesDevelopper(Websites $websitesDevelopper): self
    {
        if ($this->websitesDevelopper->removeElement($websitesDevelopper)) {
            // set the owning side to null (unless already changed)
            if ($websitesDevelopper->getDevelopper() === $this) {
                $websitesDevelopper->setDevelopper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Websites>
     */
    public function getWebsitesOwner(): Collection
    {
        return $this->websitesOwner;
    }

    public function addWebsitesOwner(Websites $websitesOwner): self
    {
        if (!$this->websitesOwner->contains($websitesOwner)) {
            $this->websitesOwner[] = $websitesOwner;
            $websitesOwner->setOwner($this);
        }

        return $this;
    }

    public function removeWebsitesOwner(Websites $websitesOwner): self
    {
        if ($this->websitesOwner->removeElement($websitesOwner)) {
            // set the owning side to null (unless already changed)
            if ($websitesOwner->getOwner() === $this) {
                $websitesOwner->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WebsitesUpdates>
     */
    public function getWebsitesUpdatesAuthor(): Collection
    {
        return $this->websitesUpdatesAuthor;
    }

    public function addWebsitesUpdatesAuthor(WebsitesUpdates $websitesUpdatesAuthor): self
    {
        if (!$this->websitesUpdatesAuthor->contains($websitesUpdatesAuthor)) {
            $this->websitesUpdatesAuthor[] = $websitesUpdatesAuthor;
            $websitesUpdatesAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeWebsitesUpdatesAuthor(WebsitesUpdates $websitesUpdatesAuthor): self
    {
        if ($this->websitesUpdatesAuthor->removeElement($websitesUpdatesAuthor)) {
            // set the owning side to null (unless already changed)
            if ($websitesUpdatesAuthor->getAuthor() === $this) {
                $websitesUpdatesAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategoriesAuthor(): Collection
    {
        return $this->categoriesAuthor;
    }

    public function addCategoriesAuthor(Categories $categoriesAuthor): self
    {
        if (!$this->categoriesAuthor->contains($categoriesAuthor)) {
            $this->categoriesAuthor[] = $categoriesAuthor;
            $categoriesAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeCategoriesAuthor(Categories $categoriesAuthor): self
    {
        if ($this->categoriesAuthor->removeElement($categoriesAuthor)) {
            // set the owning side to null (unless already changed)
            if ($categoriesAuthor->getAuthor() === $this) {
                $categoriesAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticlesAuthor(): Collection
    {
        return $this->articlesAuthor;
    }

    public function addArticlesAuthor(Articles $articlesAuthor): self
    {
        if (!$this->articlesAuthor->contains($articlesAuthor)) {
            $this->articlesAuthor[] = $articlesAuthor;
            $articlesAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeArticlesAuthor(Articles $articlesAuthor): self
    {
        if ($this->articlesAuthor->removeElement($articlesAuthor)) {
            // set the owning side to null (unless already changed)
            if ($articlesAuthor->getAuthor() === $this) {
                $articlesAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticlesFavories(): Collection
    {
        return $this->articlesFavories;
    }

    public function addArticlesFavory(Articles $articlesFavory): self
    {
        if (!$this->articlesFavories->contains($articlesFavory)) {
            $this->articlesFavories[] = $articlesFavory;
            $articlesFavory->addFavory($this);
        }

        return $this;
    }

    public function removeArticlesFavory(Articles $articlesFavory): self
    {
        if ($this->articlesFavories->removeElement($articlesFavory)) {
            $articlesFavory->removeFavory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ArticlesComments>
     */
    public function getArticlesCommentsAuthors(): Collection
    {
        return $this->articlesCommentsAuthors;
    }

    public function addArticlesCommentsAuthor(ArticlesComments $articlesCommentsAuthor): self
    {
        if (!$this->articlesCommentsAuthors->contains($articlesCommentsAuthor)) {
            $this->articlesCommentsAuthors[] = $articlesCommentsAuthor;
            $articlesCommentsAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeArticlesCommentsAuthor(ArticlesComments $articlesCommentsAuthor): self
    {
        if ($this->articlesCommentsAuthors->removeElement($articlesCommentsAuthor)) {
            // set the owning side to null (unless already changed)
            if ($articlesCommentsAuthor->getAuthor() === $this) {
                $articlesCommentsAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategoriesFavories(): Collection
    {
        return $this->categoriesFavories;
    }

    public function addCategoriesFavory(Categories $categoriesFavory): self
    {
        if (!$this->categoriesFavories->contains($categoriesFavory)) {
            $this->categoriesFavories[] = $categoriesFavory;
            $categoriesFavory->addFavory($this);
        }

        return $this;
    }

    public function removeCategoriesFavory(Categories $categoriesFavory): self
    {
        if ($this->categoriesFavories->removeElement($categoriesFavory)) {
            $categoriesFavory->removeFavory($this);
        }

        return $this;
    }
}
