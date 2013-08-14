<?php
namespace CarrinhoCompras\Model;
use Zend\Session\Container;
class Carrinho
{
    protected $container;
    protected $repositoryProduto;
    public function __construct(Container $container,$repositoryProduto)
    {
    	$this->container = $container;
    	$this->repositoryProduto = $repositoryProduto;
    }
    public function lista()
    {
        $list = $this->repositoryProduto->findByidproduto($this->container->carrinho);
    #	return $this->container->carrinho;
        return $list;
    }
}

?>