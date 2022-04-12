<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureTopAlt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureTopLink;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureTopName;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $voterNumber;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $viewNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCommented;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="articlesAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, inversedBy="articles")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="articlesFavories")
     */
    private $favories;

    /**
     * @ORM\OneToMany(targetEntity=ArticlesPictures::class, mappedBy="article", orphanRemoval=true)
     */
    private $articlesPictures;

    /**
     * @ORM\OneToMany(targetEntity=ArticlesComments::class, mappedBy="articles", orphanRemoval=true)
     */
    private $articlesComments;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->favories = new ArrayCollection();
        $this->articlesPictures = new ArrayCollection();
        $this->articlesComments = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPictureTopAlt(): ?string
    {
        return $this->pictureTopAlt;
    }

    public function setPictureTopAlt(string $pictureTopAlt): self
    {
        $this->pictureTopAlt = $pictureTopAlt;

        return $this;
    }

    public function getPictureTopLink(): ?string
    {
        return $this->pictureTopLink;
    }

    public function setPictureTopLink(string $pictureTopLink): self
    {
        $this->pictureTopLink = $pictureTopLink;

        return $this;
    }

    public function getPictureTopName(): ?string
    {
        return $this->pictureTopName;
    }

    public function setPictureTopName(string $pictureTopName): self
    {
        $this->pictureTopName = $pictureTopName;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getVoterNumber(): ?string
    {
        return $this->voterNumber;
    }

    public function setVoterNumber(?string $voterNumber): self
    {
        $this->voterNumber = $voterNumber;

        return $this;
    }

    public function getViewNumber(): ?string
    {
        return $this->viewNumber;
    }

    public function setViewNumber(?string $viewNumber): self
    {
        $this->viewNumber = $viewNumber;

        return $this;
    }

    public function getIsCommented(): ?bool
    {
        return $this->isCommented;
    }

    public function setIsCommented(?bool $isCommented): self
    {
        $this->isCommented = $isCommented;

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

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getFavories(): Collection
    {
        return $this->favories;
    }

    public function addFavory(Users $favory): self
    {
        if (!$this->favories->contains($favory)) {
            $this->favories[] = $favory;
        }

        return $this;
    }

    public function removeFavory(Users $favory): self
    {
        $this->favories->removeElement($favory);

        return $this;
    }

    /**
     * @return Collection<int, ArticlesPictures>
     */
    public function getArticlesPictures(): Collection
    {
        return $this->articlesPictures;
    }

    public function addArticlesPicture(ArticlesPictures $articlesPicture): self
    {
        if (!$this->articlesPictures->contains($articlesPicture)) {
            $this->articlesPictures[] = $articlesPicture;
            $articlesPicture->setArticle($this);
        }

        return $this;
    }

    public function removeArticlesPicture(ArticlesPictures $articlesPicture): self
    {
        if ($this->articlesPictures->removeElement($articlesPicture)) {
            // set the owning side to null (unless already changed)
            if ($articlesPicture->getArticle() === $this) {
                $articlesPicture->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArticlesComments>
     */
    public function getArticlesComments(): Collection
    {
        return $this->articlesComments;
    }

    public function addArticlesComment(ArticlesComments $articlesComment): self
    {
        if (!$this->articlesComments->contains($articlesComment)) {
            $this->articlesComments[] = $articlesComment;
            $articlesComment->setArticles($this);
        }

        return $this;
    }

    public function removeArticlesComment(ArticlesComments $articlesComment): self
    {
        if ($this->articlesComments->removeElement($articlesComment)) {
            // set the owning side to null (unless already changed)
            if ($articlesComment->getArticles() === $this) {
                $articlesComment->setArticles(null);
            }
        }

        return $this;
    }
}
