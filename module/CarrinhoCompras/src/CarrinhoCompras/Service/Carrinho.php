<?php
namespace CarrinhoCompras\Service;
use Zend\Session\Container;

class Carrinho
{
    protected $idProduto;
    protected $container;
    public function __construct(Container $container)
    {
        if(!isset($container->carrinho))  $container->carrinho = array();
        $this->container = $container;
    }
    public function adiciona()
    {
        if(!in_array($this->idProduto, $this->container->carrinho) && !empty($this->idProduto))  $this->container->carrinho[$this->idProduto] = $this->idProduto;
    }
    public function exclui()
    {
        if(in_array($this->idProduto, $this->container->carrinho) && !empty($this->idProduto))  unset($this->container->carrinho[$this->idProduto]);
    }
	public function setIdProduto($idProduto) {
		$this->idProduto = $idProduto;
	}
}

?>