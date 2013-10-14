<?php

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class CadastroRestController extends AbstractRestfulController
{
    public function getList()
    {
    	return new JsonModel();
    }
    // Retornar o registro especifico - GET
    public function get($id)
    {
        return new JsonModel();
    }
    public function create($data)
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
        if($auth->hasIdentity())
        {
            $service = $this->getServiceLocator()->get('Usuario\Service\Cadastro');
            $repository = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $repository->getRepository('Usuario\Entity\UsuarioCadastro');
                $idEntityAlvo = $entity->findOneBy(array('usuariosusuarios' => $auth->getIdentity(),'ativo' => 1));
                $service->update(array("id" => $idEntityAlvo->getIdcadastro(), 'ativo'=> 0));
            $Cadastro = $service->insert($auth->getIdentity()->getIdusuario());
            $service->update(array("id" => $Cadastro->getIdcadastro(),
            		"cep" => $data['actionCep'],
            		"rua" => $data['actionRua'],
            		"numero" => $data['actionNumero'],
            		"bairro" => $data['actionBairro'],
            		"cidade" => $data['actionCidade'],
                    "ativo" => 1,
                    "padrao" => 0
            ));
        }
        return new JsonModel();
    }
    public function update($id, $data)
    {
        return new JsonModel();
    }
}
