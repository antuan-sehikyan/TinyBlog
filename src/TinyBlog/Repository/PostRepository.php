<?php
namespace TinyBlog\Repository;

use Doctrine\ORM\EntityRepository;
use TinyBlog\Entity\Post;
//use Zend\Paginator\Paginator;

class PostRepository extends EntityRepository{

	public function findPostId($title){
		$em = $this->getEntityManager();
		$string = str_replace("-", " ", $title);
		$word = ucwords($string);

		$postId = $em->createQuery("SELECT n FROM TinyBlog\Entity\Post n WHERE n.title = :word");
		$postId->setParameter('word', $word);
		$postId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		return $postId->getArrayResult()[0]['id'];
	}

	//public function findDisabledPostId($title){
		//$em = $this->getEntityManager();
		//$string = str_replace("-", " ", $title);
		//$word = ucwords($string);

		//$postId = $em->createQuery("SELECT n FROM Blog\Entity\Post n WHERE n.title = :word AND n.status = 0");
		//$postId->setParameter('word', $word);
		//$postId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		//return $postId->getArrayResult()[0]['id'];
	//}

	//public function findPostByStatus(){
		//$em = $this->getEntityManager();
		//$posts = $em->createQuery("SELECT n FROM Blog\Entity\Post n WHERE n.status = 1");
		//return $posts->getResult();
	//}

	//public function findPostByStatus(){
        //$result = $this->createQueryBuilder('n')
			//->where('n.status = 1')
		    //->orderBy('n.postedAt', 'DESC')
		    //->getQuery()->getResult();

        //return $result;
	//}
	
	//public function findPostByStatusZero(){
        //$result = $this->createQueryBuilder('n')
			//->where('n.status = 0')
		    //->orderBy('n.postedAt', 'DESC')
		    //->getQuery()->getResult();

        //return $result;
	//}
	
	//public function getLatestPosts($limit){

        //$result = $this->createQueryBuilder('n')
			//->where('n.status = 1')
		    //->setFirstResult(0)
		    //->orderBy('n.postedAt', 'DESC')
		    //->setMaxResults($limit)
		    //->getQuery()->getResult();

        //return $result;
    //}

    public function findPostByCategory($id){
		$em = $this->getEntityManager();
		$conn = $em->getConnection();
		$statement = $conn->query("SELECT post_id, title FROM userarticles u, post p WHERE u.category_id=" . $id)->fetchAll();
		//$statement = $conn->query("SELECT post_id FROM userarticles u WHERE u.category_id=" . $id)->fetchAll();
		return $statement;
	}

	public function findNbPosts(){
		$em = $this->getEntityManager();
		$posts = $em->createQuery("SELECT COUNT(a) WHERE Blog\Entity\Post a");
		print_r($posts->getResult());
	}
}
