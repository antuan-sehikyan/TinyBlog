<?php

namespace TinyBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\FormInterface;
use TinyBlog\Entity\Category;
use TinyBlog\Form\CategoryForm;

class CategoryController extends AbstractActionController{
	
	protected $em;

	public function getEntityManager(){
		if($this->em == null){
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
    public function indexAction() {
        $resultSet = $this->getEntityManager()->getRepository('TinyBlog\Entity\Category')->findAll();
        return new ViewModel(array(
            'categories' => $resultSet
        ));
    }

    public function addAction() {
        $em = $this->getEntityManager();
        $form = new CategoryForm($em);
        $request = $this->getRequest();
        if ($request->isPost()) {
			$data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $category = new Category();
                $category->setTitle($data['title']);
                $em->persist($category);
                $em->flush();
                return $this->redirect()->toRoute('category');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
		$id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $category = $em->find('TinyBlog\Entity\Category', $id);
        $form = new CategoryForm($em);
        $form->bind($category);
        $request = $this->getRequest();
        if ($request->isPost()) {
			$data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
				$category = new Category();
				$form->bindValues();
                //$em->persist($category);
                $em->flush();
                return $this->redirect()->toRoute('category');
            }
        }
        return array('form' => $form, 'id' => $id,);
    } 

    public function deleteAction() {

        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('category');
        }
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $entity = $this->getEntityManager()->find('TinyBlog\Entity\Category', $id);
                if ($entity) {
                    $this->getEntityManager()->remove($entity);
                    $this->getEntityManager()->flush();
                }
            }
			return $this->redirect()->toRoute('category');
        }
 
        return array(
            'id' => $id,
            'category' => $this->getEntityManager()->find('TinyBlog\Entity\Category', $id)
        );
    }  
}

