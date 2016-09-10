<?php
namespace TinyBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PostForm extends Form
{
    public function __construct(ObjectManager $objectManager){
        parent::__construct('post-form');

        $this->setHydrator(new DoctrineHydrator($objectManager, 'TinyBlog\Entity\Post', true));
        $this->setAttribute('class', 'form-horizontal');
       

        $postFieldset = new PostFieldset($objectManager);
        $postFieldset->setUseAsBaseFieldset(true);
        $this->add($postFieldset);

        $this->add(array(
        		'type' => 'Zend\Form\Element\Csrf',
        		'name' => 'csrf'
        ));
               
        $submitField = new Element\Submit('submit');
        $submitField->setValue('Validation');
        $submitField->setAttribute('class', 'btn btn-primary');
        $submitField->setAttribute('id', 'submitbutton');
        $this->add($submitField); 
    }
}


