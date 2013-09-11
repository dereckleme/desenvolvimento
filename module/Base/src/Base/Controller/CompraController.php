<?php

/**
 * dereck
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Base\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Config\Reader\Xml;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class CompraController extends AbstractActionController
{    
    public function indexAction()
    {
        $filter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        $xml = new Xml();
        $cep = null;
        $valorFreteFormatado = null;
        $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
            $valorTotal = $service->calculoTotal(); //sem frete
        if($auth->hasIdentity())
        {
            $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
            $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $em->getRepository("Usuario\Entity\UsuarioCadastro")->findOneByusuariosusuarios($auth->getIdentity()->getIdusuario());
            $cep = $entity->getCep();
            $serviceFrete = $this->getServiceLocator()->get("DrkCorreios\Service\Frete");
            $serviceFrete->setSCepDestino($cep);
            $freteCalculo = $xml->fromString($serviceFrete->calcularFrete());
            if($freteCalculo['cServico']['Erro'] == 0)
            {
                $valueUpdated = str_replace("R$", "", $service->calculoTotal());
                $valueUpdated = str_replace(".", "", $valueUpdated);
                $valueUpdated = str_replace(",", ".", $valueUpdated);
                
                $valorFrete = str_replace(",", ".", $freteCalculo['cServico']['Valor']);
                $valorTotal = $filter->format($valorFrete+$valueUpdated); //Total com frete
                $valorFreteFormatado = $filter->format($valorFrete);
            }
        }
    	return new viewModel(array("carrinhoLista" => array(
    				"listaAtual" =>  $service->lista(),
    				"valorTotal" => $valorTotal
    		),"cep" => $cep, "valorFrete" => $valorFreteFormatado));
    }
    public function finalizaAction()
    {
        $filter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        $xml = new Xml();
        //Cadastro
            $nome= null;
            $cep = null;
            $endereco = null;
            $numero = null;
            $bairro = null;
            $estados = null;
            $cidades = null;
            $cidadeEstadoUF = null;
            $cidadeSelected = null;
        ///frete
            $frete = null;
        ///token
        $token = null;
        ///    
        $entity = null;
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("Usuario"));
        if($auth->hasIdentity())
        {
            $service = $this->getServiceLocator()->get('CarrinhoCompras\Model\Carrinho');
            $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
            $entity = $em->getRepository("Usuario\Entity\UsuarioCadastro")->findOneByusuariosusuarios($auth->getIdentity()->getIdusuario());
            $estados = $em->getRepository("Usuario\Entity\MapeamentoEstado")->findAll();
                    $nome = $entity->getNome();
                    $cep = $entity->getCep();
                    $endereco = $entity->getRua();
                    $numero = $entity->getNumero();
                    $bairro = $entity->getBairro();
                    if($entity->getMapeamentocidade())
                    {
                        $cidadeEstadoUF = $entity->getMapeamentocidade()->getMapeamentoestado()->getNomeclatura();
                        $cidadeSelected = $entity->getMapeamentocidade()->getIdcidade();
                    	$cidades = $em->getRepository("Usuario\Entity\MapeamentoCidade")->findBynomeclatura($cidadeEstadoUF);
                    }
                    if(!empty($cep))
                    {
                        $serviceFrete = $this->getServiceLocator()->get("DrkCorreios\Service\Frete");
                        $serviceFrete->setSCepDestino($cep);
                        $freteCalculo = $xml->fromString($serviceFrete->calcularFrete());
                        if($freteCalculo['cServico']['Erro'] == 0)
                        {
                            $valueUpdated = str_replace("R$", "", $service->calculoTotal());
                            $valueUpdated = str_replace(".", "", $valueUpdated);
                            $valueUpdated = str_replace(",", ".", $valueUpdated);
                            
                            $valorFrete = str_replace(",", ".", $freteCalculo['cServico']['Valor']);
                            $frete = array("valorFrete" => $filter->format($valorFrete), "valorfreteTotal" => $filter->format($valorFrete+$valueUpdated));
                        }
                        if(!empty($nome) && !empty($cep) && !empty($endereco) && !empty($numero) && !empty($bairro) && $frete != null)
                        {
                        	$serviceUrl = $this->getServiceLocator()->get("Pagseguro\Curl\post");
                        	$token = $serviceUrl->requisicao();
                        }
                    }    
        }
    	return new viewModel(array("carrinhoLista" => array(
    				"listaAtual" =>  $service->lista(),
    				"valorTotal" => $service->calculoTotal(),
    	            
    		),"auth" => $auth, "estados" => $estados,"cidades" => $cidades,"cidadeEstadoUF" => $cidadeEstadoUF,"cidadeSelected" => $cidadeSelected,"nomeCompleto" => $nome, "cep" => $cep,"endereco" => $endereco, "numero" => $numero, "bairro" => $bairro,"frete" =>$frete, "token" => $token));
    }
}
