<?php
namespace TinyBlog\Form;

use TinyBlog\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CategoryFieldset extends Fieldset implements InputFilterProviderInterface{
	
	public function __construct(ObjectManager $objectManager){
		parent::__construct('category');
		$this->setHydrator(new DoctrineHydrator($objectManager,'TinyBlog\Entity\Category', true))
		->setObject(new Category());

		$this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Text',
            'name'    => 'name',
            'options' => array(
                'label' => 'Category'
            )
        ));
	}

	/**
	 * @return array
	 */
	public function getInputFilterSpecification()
	{
		return array(
            'name' => array(
                'required' => true
            )
        );
	}
}
