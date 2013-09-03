<?php

namespace Usuario\Service;

use Doctrine\ORM\EntityManager;
use Base\Service\AbstractService;
class Cadastro extends AbstractService{
	
	public function __construct(EntityManager $em)
	{
		parent::__construct($em);
        $this->entity = "Usuario\Entity\UsuarioCadastro";
	}
	public function insert($idUsuario)
	{
	    $this->setTargetEntity(array(
	    		array("setTargetEntity" => "Usuario\Entity\UsuarioUsuarios",
	    				"setCampo" => "setUsuariosusuarios",
	    				"setActionReference" => $idUsuario),
	    		array("setTargetEntity" => "Usuario\Entity\MapeamentoCidade",
	    				"setCampo" => "setMapeamentocidade",
	    				"setActionReference" => 1),
	    ));
	     parent::insert(array());
	}
}

?>