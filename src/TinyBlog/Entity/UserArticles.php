<?php
namespace TinyBlog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity;
 * @ORM\Table(name="userarticles")
 */
class UserArticles{

	use \TinyBlog\Traits\ReadOnly;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
    protected $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="TinyBlog\Entity\Category", inversedBy="user_articles")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 */
	private $category;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="TinyBlog\Entity\Post", inversedBy="user_articles")
	 * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $post;

	public function getId(){
		return $this->id;
	}
	
	public function setCategory(\TinyBlog\Entity\Category $category = null){
		$this->category = $category;
		return $this;
	}

	public function getCategory(){
		return $this->category;
	}

	public function setPost(\TinyBlog\Entity\Post $post = null){
		$this->post = $post;
	}

	public function getPost(){
		return $this->post;
	}
}










