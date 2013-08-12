<?php

namespace Produto\Form;

use Zend\Form\Form;

class Produto extends Form {
	
	public function __construct($name = null) {
		parent::__construct("produto");
		
		$this->setAttribute('method','post')
			 ->setAttribute('id','formProduto')
			 ->setAttribute('class', 'form-horizontal');
		
		$this->setInputFilter(new ProdutoFilter);
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'inputCategoria',
				'options' => array(
					'value_options' => array(
						'0' => '1',
						'1' => '2',
						'2' => '3',
						'3' => '4',
						'4' => '5',
					)
				),
				'attributes' => array(
					'id' => 'inputCategoria'
				)
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\Select',
				'name' => 'inputSubCategoria',
				'options' => array(
						'value_options' => array(
								'0' => '1',
								'1' => '2',
								'2' => '3',
								'3' => '4',
								'4' => '5',
						)
				),
				'attributes' => array(
						'id' => 'inputSubCategoria'
				)
		));
		
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