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
    public function calculoTotal()
    {
        $filter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        
        $total = "";
        $list = $this->repositoryProduto->findByidproduto($this->container->carrinho);
        foreach($list AS $produto)
        {
            $total = $total+$produto->getValor();
        }
        return $filter->format($total);
    }
}

?>