<?php
namespace TinyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;

 /**
 * @Orm\Entity(repositoryClass="\TinyBlog\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post {

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
     * @ORM\Column(type="datetime")
     */
    protected $postedAt;

	/**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\OneToMany(targetEntity="TinyBlog\Entity\UserArticles", mappedBy="post",  cascade={"persist", "remove"})
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

    public function getPostedAt(){
    	if(!isset($this->postedAt)){
    	    $this->setPostedAt();
    	}
        return $this->postedAt->format('Y/m/d H:i');
    }

    public function setPostedAt(\DateTime $postedAt = null){
		if($postedAt == null){
            $postedAt = new \DateTime("now");
        }
     	$this->postedAt = $postedAt;
        return $this;
     }

    public function getContent(){
    	return $this->content;
    }

    public function setContent($value){
    	$this->content = $value;
    }

    public function addUserArticles(\TinyBlog\Entity\UserArticles $link){
        $this->user_articles->add($link);
        return $this;
    }

    public function removeUserArticles(\TinyBlog\Entity\UserArticles $link){
    	$this->user_articles->removeElement($link);
    	return $link;
    }

    public function getUserArticles(){
    	return $this->user_articles;
    }

    public function addCategory(Category $category){
        $link = new UserArticles();
        $link->setCategory($category);
        $link->setPost($this);
        $this->addUserArticles($link);
        return $link;
    }

    public function removeCategory(Category $category){
        throw new \Exception("Not used");
    }

    public function removeCategoryById($catId){
        throw new \Exception("Not used");
    }

    /**
    *  @ORM\PrePersist
    */
	public function prePersist(){
        $this->getPostedAt();
    }

}
