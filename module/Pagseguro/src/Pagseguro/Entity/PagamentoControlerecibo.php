<?php

namespace Pagseguro\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="pagamento_controlerecibo")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Pagseguro\Entity\PagamentoControlereciboRepository")
 */
class PagamentoControlerecibo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idControleRecibo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcontrolerecibo;

    /**
     * @var string
     *
     * @ORM\Column(name="nPedido", type="string", length=255, nullable=false)
     */
    private $npedido;

    /**
     * @var integer
     *
     * @ORM\Column(name="fPagamento", type="integer", nullable=false)
     */
    private $fpagamento;

    /**
     * @var integer
     *
     * @ORM\Column(name="sPagamento", type="integer", nullable=false)
     */
    private $spagamento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_venda", type="datetime", nullable=true)
     */
    private $dtVenda;

    /**
     * @var float
     *
     * @ORM\Column(name="valor", type="decimal", nullable=true)
     */
    private $valor;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Pagseguro\Entity\UsuarioUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Usuario_idUsuarios", referencedColumnName="idUsuario")
     * })
     */
    private $usuariousuarios;
    
	public function getIdcontrolerecibo() {
		return $this->idcontrolerecibo;
	}

	public function getNpedido() {
		return $this->npedido;
	}

	public function getFpagamento() {
		return $this->fpagamento;
	}

	public function getSpagamento() {
		return $this->spagamento;
	}

	public function getDtVenda() {
		return $this->dtVenda;
	}

	public function getValor() {
		return $this->valor;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getUsuariousuarios() {
		return $this->usuariousuarios;
	}

	public function setIdcontrolerecibo($idcontrolerecibo) {
		$this->idcontrolerecibo = $idcontrolerecibo;
	}

	public function setNpedido($npedido) {
		$this->npedido = $npedido;
	}

	public function setFpagamento($fpagamento) {
		$this->fpagamento = $fpagamento;
	}

	public function setSpagamento($spagamento) {
		$this->spagamento = $spagamento;
	}

	public function setDtVenda($dtVenda) {
		$this->dtVenda = $dtVenda;
	}

	public function setValor($valor) {
		$this->valor = $valor;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setUsuariousuarios($usuariousuarios) {
		$this->usuariousuarios = $usuariousuarios;
	}

    

}
