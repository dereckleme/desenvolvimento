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


class UsuarioController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function novoUserAction()
    {
        if($this->request->isPost())
        {
            $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $em->getRepository("Usuario\Entity\UsuarioUsuarios");
            $requestArray = $this->getRequest()->getPost()->toArray();
                if(count($entity->findOneByLogin($requestArray['eventLogin'])) != 0 || empty($requestArray['eventLogin'])) $error[] = "- Login usado já existe, ou está em branco:\n";
                if(count($entity->findOneByEmail($requestArray['eventEmail'])) != 0 || empty($requestArray['eventEmail'])) $error[] = "- Email já está cadastrado, ou está em branco::";
                if(count($error) == 0)
                    {
                        $service = $this->getServiceLocator()->get('Usuario\Service\Usuario');
                        $service->insert(array('login' => $requestArray['eventLogin'], 'email' => $requestArray['eventEmail'], 'senha' => md5($requestArray['eventPassword'])));
                        $viewModel = new ViewModel(array('message' => 1));
                    }
                    else
                    {
                        $viewModel = new ViewModel(array('message' => implode($error)));
                    }
        }
        else
        {
            $viewModel = new ViewModel(array('message' => 0));
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
    public function ativarUserAction()
    {
    	
    }
}
