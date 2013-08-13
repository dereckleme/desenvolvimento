<?php
namespace Pagseguro\Curl;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl; // Biblioteca zend curl
use Doctrine\ORM\EntityManager;

use Zend\Config\Reader\Xml;
class Post
{
   protected $dados; 
    public function __construct($email,$token,$currency)
    {
        $this->dados[] = 'email='.$email;
        $this->dados[] = 'token='.$token;
        $this->dados[] = 'currency='.$currency;
    }
    public function requisicao()
    {
        $this->dados[] ="itemId1=1010";
        $this->dados[] ="itemDescription1=teste dereck";
        $this->dados[] ="itemAmount1=24300.00";
        $this->dados[] ="itemQuantity1=1";
        
        
        $this->dados[] ="itemId2=111";
        $this->dados[] ="itemDescription2=dereck drk";
        $this->dados[] ="itemAmount2=50.00";
        $this->dados[] ="itemQuantity2=1";
        
        $dados = implode("&", $this->dados);
        
        $request = new Request;
        $postString = "username=dereck&password=leme";
        $request->getHeaders()->addHeaders([
        		'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        		]);
        $request->setUri('https://ws.pagseguro.uol.com.br/v2/checkout');
        $request->setMethod('POST'); //uncomment this if the POST is used
        $request->setContent($dados);
        
        $client = new Client;
        $adapter = new Curl();
        $adapter->setOptions(array(
        		'curloptions' => array(
        				CURLOPT_POST => 1,
        				CURLOPT_SSL_VERIFYPEER => FALSE,
        				CURLOPT_SSL_VERIFYHOST => FALSE,
        		)
        ));
        $client->setAdapter($adapter);
        $retorno = $client->dispatch($request)->getContent();
        
        $xml = new Xml();
              if($retorno != "Unauthorized" && !empty($retorno))
              {
           $data = $xml->fromString($retorno);
              }
        return $data['code'];
    }
}

?>