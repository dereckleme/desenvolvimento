<?php
namespace Produto\Form;

use Zend\InputFilter\InputFilter;

class ProdutoFilter extends InputFilter {
    
    public function __construct(){
    	
        $this->add(array(
            'name'       => 'titulo',
            'required'   => true,
            'filters'    => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim')
            ),
            'validators' => array(
                array(
                    'name'     => 'NotEmpty',
                    'options'  => array(
                        'messages' => array('isEmpty'=>'O titulo esta em branco.')
                    )    
                )
            )
        ));
        
    }
    
}