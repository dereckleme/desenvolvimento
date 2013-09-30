<?php
namespace Produto\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Base\Service\AbstractService;

class NutricionalTabela extends AbstractService
{
    public function __construct(EntityManager $em){
    	parent::__construct($em);
    	$this->entity = "Produto\Entity\ProdutoNutricional";
    }
    
    public function insert(array $data){       
        $this->setTargetEntity(array(
    		array(
    		    "setTargetEntity" => "Produto\Entity\ProdutoNutricionalNomes",
    			"setCampo" => "setProdutonutricionalNomes",
    			"setActionReference" => $data['idnutricionalNomes']
            ),
    		array(
    		    "setTargetEntity" => "Produto\Entity\ProdutoProdutos",
    			"setCampo" => "setProdutoproduto",
    			"setActionReference" => $data['idproduto']
            ),
        ));
        
        return parent::insert($data);
    }
    
    
    
    
    
}