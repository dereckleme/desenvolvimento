<?php

/**
 * dereck
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


use Zend\Authentication\AuthenticationService,
Zend\Authentication\Storage\Session as SessionStorage;

class UsuarioController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function novoUserAction()
    {
        $error = array();
        if($this->request->isPost())
        {
            
            $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $em->getRepository("Usuario\Entity\UsuarioUsuarios");
            $requestArray = $this->getRequest()->getPost()->toArray();
                if(count($entity->findOneByLogin($requestArray['eventLogin'])) != 0 || empty($requestArray['eventLogin'])) $error[] = "- Login usado já existe, ou está em branco:<br/>";
                if(count($entity->findOneByEmail($requestArray['eventEmail'])) != 0 || empty($requestArray['eventEmail'])) $error[] = "- Email já está cadastrado, ou está em branco:<br/>";
                if(empty($requestArray['eventPassword']) || ($requestArray['eventPassword'] != $requestArray['eventPasswordConfirm'])) $error[] = "- Senha cadastrada está em branco ou não coincide:";

                if(count($error) == 0)
                    {
                        $service = $this->getServiceLocator()->get('Usuario\Service\Usuario');
                        $action = $service->insert(array('login' => $requestArray['eventLogin'], 'email' => $requestArray['eventEmail'], 'senha' => md5($requestArray['eventPassword'])));
                            $idUsuario = $action->getIdusuario();
                            $service = $this->getServiceLocator()->get('Usuario\Service\Cadastro');
                            $service->insert($idUsuario);
                            $viewModel = new ViewModel(array('message' => 1));
                    }
                    else
                    {
                        $viewModel = new ViewModel(array('message' => implode($error)));
                    }
        }
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    public function editaUserAction()
    {
        $teste = $this->getServiceLocator()->get("Produto\Repository\SubCategorias")->findAll();
        foreach ($teste as $dereck)
        {
        	print $dereck->getNome();
        }
        die();
    }

    public function atualizaAction()
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
        if($auth->hasIdentity())
        {
            if($this->request->isPost())
            {
                $requestArray = $this->getRequest()->getPost()->toArray();
                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                    $entity = $em->getRepository("Usuario\Entity\UsuarioCadastro")->findOneByusuariosusuarios($auth->getIdentity()->getIdusuario());
                    $service = $this->getServiceLocator()->get('Usuario\Service\Cadastro');
                    $service->update(array("id" => $entity->getIdcadastro(), 
                        "nome" => $requestArray['actionNome'], 
                        "cep" => $requestArray['actionCep'], 
                        "rua" => $requestArray['actionRua'],
                        "numero" => $requestArray['actionNumero'],
                        "bairro" => $requestArray['actionBairro'],
                        "cidade" => $requestArray['actionCidade'],
                    ));
                $viewModel = new ViewModel(array('message' => 1));
            }
            else 
            {
                $viewModel = new ViewModel(array('message' => 0));
            }    
        }
        else
        {
            $viewModel = new ViewModel(array('message' => 0));
        }   
    	
    	$viewModel->setTerminal(true);
    	return $viewModel;
    }
    public function ativarUserAction()
    {
    	
    }
}
