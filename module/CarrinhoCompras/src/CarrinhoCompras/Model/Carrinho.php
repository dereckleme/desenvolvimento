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
        foreach($this->container->carrinho AS $iten)
        {
        	$selectedItens[] = $iten['idProduto'];
        }
        $list = $this->repositoryProduto->findByidproduto($selectedItens);
            foreach($list AS $produto)
            {
                $idProduto = $produto->getIdproduto();
            	$configSessionProdutos[] = array(
            	    "produto" => $produto,
            	    "quantidade" => $this->container->carrinho[$idProduto]['quantProd']
            	);
            }
    #	return $this->container->carrinho;
        return $configSessionProdutos;
    }
    public function calculoTotal()
    {
        $filter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        
        $total = "";
        foreach($this->container->carrinho AS $iten)
        {
        	$selectedItens[] = $iten['idProduto'];
        }
        $list = $this->repositoryProduto->findByidproduto($selectedItens);
        foreach($list AS $produto)
        {
            $idProduto = $produto->getIdproduto();
            $valorIten = $produto->getValor()*$this->container->carrinho[$idProduto]['quantProd'];
            $total = $total+$valorIten;
        }
        return $filter->format($total);
    }
}

?>