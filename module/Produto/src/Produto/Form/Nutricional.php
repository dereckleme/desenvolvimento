<?php

namespace Produto\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select,
    Zend\Form\Element\Hidden;   
use Doctrine\DBAL\Event\SchemaEventArgs;

class Nutricional extends Form {
	
	public function __construct($name = null) {
		parent::__construct("nutricional");
		
		$this->setAttribute('method','post')
			 ->setAttribute('id','formNutricional')
			 ->setAttribute('class', 'form-horizontal');
		
		$this->setInputFilter(new NutricionalFilter);
		
		$hidden = new Hidden('idprodutoNutricional');		
		$this->add($hidden);
		
		$select = new Select('idnutricionalNomes');
		$select->setAttribute('id', 'idnutricionalNomes');
		$this->add($select);		
		
		$select2 = new Select('idproduto');
		$select2->setAttribute('id', 'idproduto');		
		$this->add($select2);
		
		
		$this->add(array(
			'name' => 'quantidade',
			'options' => array(
				'type' => 'text',
			),
			'attributes' => array(
				'id' => 'quantidade'
			)
		));
		
		$this->add(array(
			'name' => 'vd',
			'options' => array(
				'type' => 'text',
			),
			'attributes' => array(
				'id' => 'vd'
			)
		));
		
	}
		
	
}