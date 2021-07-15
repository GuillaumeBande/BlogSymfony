<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Rempli le titre PUT1")
     * *@Assert\Length(
     *              min = 2,
     *              max = 10,
     *              minMessage = "Vous devez écrire plus de {{ limit }} caractères.",
     *              maxMessage = "Vous ne pouvez pas ecrire plus de {{ limit }} caractères"
     *              )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *@Assert\Length(
     *              min = 2,
     *              max = 50,
     *              minMessage = "Vous devez écrire plus de {{ limit }} caractères.",
     *              maxMessage = "Vous ne pouvez pas ecrire plus de {{ limit }} caractères"
     *              )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     */
    private $category;

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }


    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="yes")
     */
    private $tag;

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function setCreateAt($DateTime)
    {
    }

    public function setPublished(string $string)
    {
        $this->isPublished;
    }
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

}