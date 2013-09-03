<?php
namespace DrkCorreios\Service;

use Base\Http\AbstractCurl;

class Frete extends AbstractCurl
{
    protected $sCepDestino;
    protected $nVlPeso;
    protected $nCdFormato;
    protected $nVlComprimento;
    protected $nVlAltura;
    protected $nVlLargura;
    protected $nVlDiametro;
    
    
    protected $dados;
    public function __construct(){
        parent::__construct();
    	$this->action = 'GET';
    }
    public function calcular()
    {
        $this->dados[] ="nCdEmpresa=09146920";
        $this->dados[] ="sDsSenha=123456";
        $this->dados[] ="sCepOrigem=70002900";
        $this->dados[] ="sCepDestino=".$this->sCepDestino;
        $this->dados[] ="nVlPeso=".$this->nVlPeso;
        $this->dados[] ="nCdFormato=1";
        $this->dados[] ="nVlComprimento=".$this->nVlComprimento;
        $this->dados[] ="nVlAltura=".$this->nVlAltura;
        $this->dados[] ="nVlLargura=".$this->nVlLargura;
        $this->dados[] ="sCdMaoPropria=n";
        $this->dados[] ="nVlValorDeclarado=0";
        $this->dados[] ="sCdAvisoRecebimento=n";
        $this->dados[] ="nCdServico=40010";
        $this->dados[] ="nVlDiametro=0";
        $this->dados[] ="StrRetorno=xml";
        $this->dados[] ="nIndicaCalculo=3";
        $dados = implode("&", $this->dados);
        $this->uri = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?$dados";
        $content = parent::requisicao(array());
        return $content;
    }
	public function setSCepDestino($sCepDestino) {
		$this->sCepDestino = $sCepDestino;
	}

	public function setNVlPeso($nVlPeso) {
		$this->nVlPeso = $nVlPeso;
	}

	public function setNCdFormato($nCdFormato) {
		$this->nCdFormato = $nCdFormato;
	}

	public function setNVlComprimento($nVlComprimento) {
		$this->nVlComprimento = $nVlComprimento;
	}

	public function setNVlAltura($nVlAltura) {
		$this->nVlAltura = $nVlAltura;
	}

	public function setNVlLargura($nVlLargura) {
		$this->nVlLargura = $nVlLargura;
	}

	public function setNVlDiametro($nVlDiametro) {
		$this->nVlDiametro = $nVlDiametro;
	}

	public function setDados($dados) {
		$this->dados = $dados;
	}

}