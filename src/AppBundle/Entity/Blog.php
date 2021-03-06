<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Blog
 *
 * @ORM\Table(name="blog", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Blog
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="excerpt", type="string", length=100, nullable=false)
     */
    private $excerpt;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="body", type="text", nullable=false)
     */
    private $body;

    /**
     * @var boolean
     * @Assert\NotNull()
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category", inversedBy="categoryBlogs")
     * @ORM\JoinTable(name="blog_category")
     */
    private $blogCategories;

//    /**
//     * @var string
//     * @ORM\Column(name="slug" , type="string" , nullable=false , unique=true)
//     */
//    private $slug;

    public function __construct()
    {
        $this->blogCategories = new ArrayCollection();
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     *
     * @return Blog
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Blog
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Blog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Blog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Blog
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getBlogCategories()
    {
        return $this->blogCategories;
    }

    /**
     * @param mixed $blogCategories
     */
    public function setBlogCategories($blogCategories)
    {
        $this->blogCategories = $blogCategories;
    }

    public function addBlogCategory(Category $category){
        if($this->blogCategories->contains($category)){
            return;
        }
        $this->blogCategories[] = $category;
    }

//    /**
//     * @return mixed
//     */
//    public function getSlug()
//    {
//        return $this->slug;
//    }
//
//    /**
//     * @param mixed $slug
//     */
//    public function setSlug($slug)
//    {
//        $this->slug = $slug;
//    }

}
