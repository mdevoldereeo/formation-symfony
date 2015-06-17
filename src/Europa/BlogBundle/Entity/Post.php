<?php

namespace Europa\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="post.title.notBlank.message")
     * @Assert\Length(
     * min=10, 
     * max=200, 
     * minMessage="post.title.lengthmin.message", maxMessage="post.title.lengthmax.message",
     * groups={"publishing", "Default"}
     * ) 
     * 
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedate", type="datetime")
     */
    private $publishedate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Author", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @var type Author
     */
    private $author;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="posts")
     * @var ArrayCollection 
     */
    private $tags;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128)
     * @var string
     */
    //private $slug;

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
     * Set title
     *
     * @param string $title
     * @return Post
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
     * @return Post
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
     * Set publishedate
     *
     * @param \DateTime $publishedate
     * @return Post
     */
    public function setPublishedate($publishedate)
    {
        $this->publishedate = $publishedate;

        return $this;
    }

    /**
     * Get publishedate
     *
     * @return \DateTime 
     */
    public function getPublishedate()
    {
        return $this->publishedate;
    }

    /**
     * Set author
     *
     * @param \Europa\BlogBundle\Entity\Author $author
     * @return Post
     */
    public function setAuthor(\Europa\BlogBundle\Entity\Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Europa\BlogBundle\Entity\Author 
     */
    public function getAuthor()
    {
        return $this->author;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \Europa\BlogBundle\Entity\Tag $tags
     * @return Post
     */
    public function addTag(\Europa\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Europa\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\Europa\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function setDefaultPublishedate()
    {
        if(!$this->publishedate) {
            $this->publishedate = (new \DateTime('+1 day'));
        }
    }
    
}
