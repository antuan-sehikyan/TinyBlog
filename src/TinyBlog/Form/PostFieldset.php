<?php
namespace TinyBlog\Form;

use TinyBlog\Entity\Post;
use Zend\Form\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class PostFieldset extends Fieldset implements InputFilterProviderInterface{
	
    public function __construct(ObjectManager $objectManager){
		
        parent::__construct('post');
        $this->setHydrator(new DoctrineHydrator($objectManager,'TinyBlog\Entity\Post', true))
             ->setObject(new Post());
        $this->setAttribute('id', 'add-form'); 
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
    		'name' => 'id'
        ));
        
        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
    		'name' => 'title',
    		//'options' => array(
				//'label' => 'Name of Post'
    		//),
    		'attributes' => array(
				'required' => 'required',
                'class' => 'form-control',
                'placeholder' => 'Name of Post'				
    		)
        ));
        
        $this->add(array(
            'type'    => 'Zend\Form\Element\Textarea',
    		'name' => 'content',
    		'attributes' => array(
				'required' => 'required',
                'class' => 'form-control',
                'placeholder' => 'Content of Post',
                'id' => 'textarea'               				
    		)
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\DateTimeSelect',
    		'options' => array(
				'label' => 'Select Posted Date:', 				
    		),            
    		'name' => 'postedAt',
    		'attributes' => array(
				'required' => 'required',
                'class' => 'form-control'             			
    		)
        ));
		
        $categoryFieldset = new CategoryFieldset($objectManager);
        $this->add(array(
            'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'categories',
    		'options' => array(
				'label' => 'Select Categories:',
    		    'object_manager' => $objectManager,
    		    'should_create_template' => true,
        		'target_class'   => 'TinyBlog\Entity\Category',
    		    'property'       => 'title',
				'target_element' => $categoryFieldset,
    		),
    		'attributes' => array(
                'class' => 'checkbox',				
			)
        ));
        
    }

    public function getInputFilterSpecification() {
        return array(
            'content' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'stringtrim'),
                    array('name' => 'htmlpurifier'),
                ),
            ),
        );
    }   

}
