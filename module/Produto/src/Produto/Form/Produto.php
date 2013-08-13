<?php

namespace Produto\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;
use Doctrine\DBAL\Event\SchemaEventArgs;

class Produto extends Form {
	
	public function __construct($name = null) {
		parent::__construct("produto");
		
		$this->setAttribute('method','post')
			 ->setAttribute('id','formProduto')
			 ->setAttribute('class', 'form-horizontal');
		
		$this->setInputFilter(new ProdutoFilter);
		
		$select = new Select('inputCategoria');
		$select->setAttribute('id', 'inputCategoria');
		$this->add($select);		
		
		$select2 = new Select('inputSubCategoria');
		$select2->setAttribute('id', 'inputSubCategoria');
		$select2->setValueOptions(array(''=>'--SELECIONE--'));
		$this->add($select2);
		
		
		$this->add(array(
				'name' => 'titulo',
				'options' => array(
					'type' => 'text',
				),
				'attributes' => array(
					'placeholder' => 'Titulo',
					'id' => 'inputTitulo'
				)
		));
		
		$this->add(array(
				'name' => 'valor',
				'options' => array(
					'type' => 'text',
				),
				'attributes' => array(
					'placeholder' => 'R$ 0,00',
					'id' => 'inputValor'
				)
		));
		
	}
		
	
}