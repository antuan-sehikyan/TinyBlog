<?php
namespace TinyBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Blog\Entity\Category;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CategoryForm extends Form {

    public function __construct() {
        parent::__construct('category');
        $this->setHydrator(new ClassMethodsHydrator(false));
       
		$this->add(array(
			'name' => 'id',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'title',
			'type' => 'text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'category'
			)
		));
		
		$submitField = new Element\Submit('submit');
		$submitField->setValue('Validation');
		$submitField->setAttribute('class', 'btn');
		$submitField->setAttribute('id', 'submitbutton');
		$this->add($submitField);		
    }

}
