<?php
namespace TinyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category{

	use \TinyBlog\Traits\ReadOnly;

    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $title;
    
    /**
     * @ORM\OneToMany(targetEntity="UserArticles", mappedBy="category",  cascade={"persist", "remove"})
     */
    protected $user_articles; 
    
    public function __construct() {
        $this->user_articles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId(){
    	return $this->id;
    }
    
    public function setId($value){
    	$this->id = $value;
    }
    
    public function getTitle(){
        return $this->title;
    }
    
    public function setTitle($value){
    	$this->title = $value;
    }

    public function addUserArticles(\TinyBlog\Entity\UserArticles $link){
    	$this->user_articles->add($link);   
    	return $this;
    }

    public function removeUserArticles(\TinyBlog\Entity\UserArticles $link){
    	$this->user_articles->removeElement($link);
    }

    public function getUserArticles(){
    	return $this->user_articles;
    }
    
}
