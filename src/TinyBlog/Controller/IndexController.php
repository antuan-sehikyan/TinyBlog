<?php

namespace TinyBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use TinyBlog\Entity\Post;
use TinyBlog\Form\PostForm;
use Soflomo\Common\Form\FormUtils;

class IndexController extends AbstractActionController{
	
	protected $em;

	public function getEntityManager(){
		if($this->em == null){
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
    public function indexAction() {
        $resultSet = $this->getEntityManager()->getRepository('TinyBlog\Entity\Post')->findAll();
        return new ViewModel(array(
            'posts' => $resultSet
        ));
    }

    public function addAction() {

        $em = $this->getEntityManager();
		//$id = $this->getProfileId();
		//$user = $em->find('User\Entity\Profile', $id);

        $form = new PostForm($em);
        FormUtils::injectFilterPluginManager($form, $this->getServiceLocator()); //*********************************
        $post = new Post();
        $form->bind($post);

        $request = $this->getRequest();
        if ($request->isPost()) {
        	$form->setData($request->getPost());

        	if ($form->isValid()) {
        	    $data = $form->getData();

        	    $element = $form->getBaseFieldset()->get('categories');
        	    $values = $element->getValue();
				//var_dump($data);die;
        	    foreach($values as $categoryID){
        	        $results = $em->getRepository('TinyBlog\Entity\Category')->findBy(array('id' => $categoryID));
        	        $categoryEntity = array_pop($results);
        	        $categoryegorie_id = $post->addCategory($categoryEntity);
        	    }
        	    $string = ucwords($post->getTitle());
        	    $post->setTitle($string);
        	    //$post->setUser($user);
         		$em->persist($post);
         		$em->flush();

        		return $this->redirect()->toRoute('tiny-blog');
        	}
        }
		return new ViewModel(array(
			'form' => $form
		));
	}
	
    public function editAction() {

        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
        	return $this->redirect()->toRoute('tiny-blog');
        }

        $em = $this->getEntityManager();
        $form = new PostForm($em);
        FormUtils::injectFilterPluginManager($form, $this->getServiceLocator()); //*********************************        
        $post = $em->find('TinyBlog\Entity\Post', $id);
        $form->bind($post);

        $element = $form->getBaseFieldset()->get('categories'); 
        $categoryegories_ids = $em->getRepository('TinyBlog\Entity\UserArticles')->findBy(array('post' => $post));
        
        $associated_categoryegories = array();
        foreach($categoryegories_ids as $categoryegorie_id){
            $categoryId = $categoryegorie_id->getCategory()->getId();
            array_push($associated_categoryegories, $categoryId);
        }
        $element->setValue($associated_categoryegories);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$form->setData($request->getPost());
            
        	if ($form->isValid()) {
        	    $entityValue = $element->getValue();

        	    $removeList = array_diff($associated_categoryegories, $entityValue);
        	    $addList = array_diff($entityValue, $associated_categoryegories);
        	    
        	    foreach($removeList as $removeId){
        	        foreach($categoryegories_ids as $categoryegorie_id){
        	        	$category = $categoryegorie_id->getCategory();
        	        	if($category->getId() == $removeId){
        	        	    $post->removeUserArticles($categoryegorie_id);
        	        	    $em->remove($categoryegorie_id);
        	        	}
        	        }        	              	        
        	    }
        	    
        	    foreach($addList as $addId){
                    $categoryegory = $em->find('TinyBlog\Entity\Category', $addId);
        	        $post->addCategory($categoryegory);
        	    } 
        	    
        	    $string = ucwords($post->getTitle());
        	    $post->setTitle($string);        	         	    
        		$em->flush();
        		return $this->redirect()->toRoute('tiny-blog');
        	}
        }
        
        return array(
            'id' => $id,
            'form' => $form
        );
    }
    
    public function deleteAction() {

        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('tiny-blog');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $entity = $this->getEntityManager()->find('TinyBlog\Entity\Post', $id);
                if ($entity) {
                    $this->getEntityManager()->remove($entity);
                    $this->getEntityManager()->flush();
                }
            }
			return $this->redirect()->toRoute('tiny-blog');
        }
 
        return array(
            'id' => $id,
            'post' => $this->getEntityManager()->find('TinyBlog\Entity\Post', $id)
        );
    } 
    
 	public function getPostRepository(){
		$em = $this->getEntityManager();
		return $em->getRepository('TinyBlog\Entity\Post');
	}
	   
 	public function viewAction(){

		$em = $this->getEntityManager();
		$title = (string)$this->getEvent()->getRouteMatch()->getParam('title');        		
		$postId = $this->getPostRepository()->findPostId($title);
				
		$post = $this->getEntityManager()->find('TinyBlog\Entity\Post', $postId);
        if ($post === null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		$postTile = $post->getTitle();		
		$categories = $em->getRepository('TinyBlog\Entity\Category')->findAll();

    	return new ViewModel(array(
			'post' => $post,
			'title' => $postTile,
			'id' => $postId,
			'categories' => $categories,			
		));

	}   
    
       	
}

