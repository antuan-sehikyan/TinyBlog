<?php
namespace Blog\Repository;

use Doctrine\ORM\EntityRepository;
use Blog\Entity\Category;

class CategoryRepository extends EntityRepository{
	
	public function findCategoryId($category){
		$em = $this->getEntityManager();
		$string = str_replace("-", " ", $category);
		$word = ucwords($string);
		
		$catId = $em->createQuery("SELECT n FROM Blog\Entity\Category n WHERE n.title = :word");				
		$catId->setParameter('word', $word);
		$catId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

		return $catId->getArrayResult()[0]['id'];	
	}
	
	//public function findPostsByCategory($catId){
		//$em = $this->getEntityManager();
		//$conn = $em->getConnection();
		//$statement = $conn->query("select post_id from userarticles where userarticles.category_id=" . $catId)->fetchAll();
		
		//$post_ids = array();

		//foreach($statement as $post) {
			//$post_ids[] = (int)$post["post_id"];			
		//}
		
	
		//foreach($statement as $post) 
		////{
			////echo '<pre>';	
			////var_dump($post["post_id"]);					
			////echo '</pre>'; 
		////}
				
		////echo '<pre>';		
 		////var_dump($post_ids);		
 		////echo '</pre>'; 
 		
 
 		//$posts = $em->createQuery("SELECT p FROM Blog\Entity\Post p WHERE p.id = " . (int)$post["post_id"]);
 		//$posts->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
 		////foreach($posts as $post) 
		////{
			////echo '<pre>';	
			
			//var_dump($posts->getArrayResult());					
			////echo '</pre>'; 
		////}
		
 		////$posts->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
 		////return $posts->getArrayResult();
 		
 		////$results = $posts->getResult();
		////echo '<pre>';		
 		////foreach($results as $poste) 
		////{
			////echo '<pre>';	
			
			////var_dump($poste->title);					
			////echo '</pre>'; 
		////}	
 		////echo '</pre>';  			
	//}
	
	//public function findPostsByCategory($catId){
		//$em = $this->getEntityManager();
		//$conn = $em->getConnection();
		//$statement = $conn->query("select * from userarticles where userarticles.category_id=" . $catId)->fetch();
		
		//foreach($statement as $post) $post_id = $post["post_id"];				
		//echo '<pre>';
		//print_r($statement);
		//echo '</pre>';

		//$poststmt = $conn->query("select * from post where post.id = " . $post_id)->fetch();
		////while($poststmt){
			////$poststmt['id'] = $post_id;
		//echo '<pre>';
		//print_r($post_id);
		//echo '</pre>';
		////}	
	//}
		
	//public function findCategoryId($category){
		//$em = $this->getEntityManager();
		//$catId = $em->createQuery("SELECT c,p FROM Blog\Entity\Category c, Blog\Entity\Post p WHERE c.title = :category AND p.status = 1");
		//$catId->setParameter('category', $category);
		//$catId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		//echo '<pre>';
		//print_r($catId->getArrayResult());
		//echo '</pre>';
		//return $catId->getArrayResult()[0]['id'];	
	//}	
	
	//public function findCategoryId(){
		//$em = $this->getEntityManager();
		//$catId = $em->createQuery("SELECT c,p FROM \Blog\Entity\Category c, \Blog\Entity\Post p WHERE p.status = 1");
		////$catId->setParameter('category', $category);
		//$catId->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		//echo '<pre>';
		//print_r($catId->getArrayResult());
		//echo '</pre>';
		//return $catId->getArrayResult()[0]['id'];	
	//}
}
