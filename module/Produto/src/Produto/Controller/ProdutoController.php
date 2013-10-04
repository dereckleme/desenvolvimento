<?php

/**
 * dereck
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Produto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Produto\Form\Produto as FrmProduto;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Produto\Entity\ProdutoProdutos;


use Zend\Validator\File\Size;
use Zend\File\Transfer\Adapter\Http;
use Zend\Filter\File\Rename;

class ProdutoController extends AbstractActionController
{

    protected $categoriaValue;
    protected $subCategoriaValue;
    protected $uploadPath = 'public/images/produtos/';

    public function getCategoryValuesOptions ()
    {
        if (! $this->categoriaValue) {
            $repository = $this->getServiceLocator()->get("Produto\Repository\Categorias");
            
            $this->categoriaValue[""] = "--SELECIONE--";
            foreach ($repository->findAll() as $result) {
                $this->categoriaValue[$result->getIdcategorias()] = $result->getNome();
            }
        }
        return $this->categoriaValue;
    }

    public function getSubCategoryValuesOptions ()
    {
        if (! $this->subCategoriaValue) {
            $repository = $this->getServiceLocator()->get("Produto\Repository\SubCategorias");
            
            $this->subCategoriaValue[""] = "--SELECIONE--";
            foreach ($repository->findAll() as $result) {
                $this->subCategoriaValue[$result->getIdsubcategoria()] = $result->getNome();
            }
        }
        return $this->subCategoriaValue;
    }

    public function indexAction ()
    {
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $repositorCat = $this->getServiceLocator()->get("Produto\Repository\Categorias");
        
        $list = $repositor->findAll();
        $page = $this->params()->fromRoute('page');
        
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page);
        $paginator->setDefaultItemCountPerPage(2);
        
        return new ViewModel(array(
            "categorias" => $repositorCat->findAll(),
            "produto" => $paginator
        ));
    }

    public function subCategoriaByCategoriaAction ()
    {
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Categorias");
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->getRequest()->getPost('valor');
            
            $valueOptions = "<option value=''>--SELECIONE--</option>\n";
            foreach ($repositor->findByIdcategorias($data) as $categoria) {
                foreach ($categoria->getSubcategorias() as $subcategoria) {
                    $valueOptions .= "<option value='{$subcategoria->getIdsubcategoria()}'>{$subcategoria->getNome()}</option>\n";
                }
            }
        } else {
            $valueOptions = "Erro interno.";
        }
        
        $viewModel = new ViewModel(array(
            'mensagem' => $valueOptions
        )); // chama uma view
        $viewModel->setTerminal(true); // desativa layout.phtml
        return $viewModel;
    }

    public function adicionarAction ()
    {
        $form = new FrmProduto();
        $select = $form->get('inputCategoria');
        $select->setValueOptions($this->getCategoryValuesOptions());
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function criarProdutoAction ()
    {
        $form = new FrmProduto();
        $comboCategoria = $form->get('inputCategoria');
        $comboCategoria->setValueOptions($this->getCategoryValuesOptions());
        
        $comboSubCategoria = $form->get('inputSubCategoria');
        $comboSubCategoria->setValueOptions($this->getSubCategoryValuesOptions());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $noFile = $request->getPost()->toArray();
            $File = $this->params()->fromFiles('foto');
            $data = array_merge($noFile, array('foto' => $File[0]));
            $form->setData($data);
            
            if ($form->isValid()) {
                $size = new Size(array('max' => 2000000));
                $adpter = new Http();
                $adpter->setValidators(array($size), $File);
                
                if (! $adpter->isValid()) {
                    $dataError = $adpter->getMessages();
                    $error = array();
                    foreach ($dataError as $erro) {
                        $error[] = $erro;
                    }
                    echo "<pre>", print_r($error), "</pre>";
                } else {
                    
                    $diretorio = $request->getServer()->DOCUMENT_ROOT . '/seletoLoja/public/images/produtos/large';                   
                    $adpter->setDestination($diretorio);
                    
                    $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
                    
                    foreach ($adpter->getFileInfo() as $file => $info) {                        
                        $name = $adpter->getFileName($file);
                        // fname = $diretorio . '/' . substr(md5(microtime()), 1, 4).$info['name'];
                        $fname = substr(md5(microtime()), 1, 4) . $info['name'];
                        $adpter->addFilter(new Rename(array(
                            "target" => $fname,
                            "randomize" => false
                        )), null, $file);
                                                
                        if ($adpter->receive($file)) {
                            
                            $size = getimagesize($diretorio.'/'.$fname);
                            if($size[1] > 1000 )
                            {
                                $resize = $thumbnailer->create('public/images/produtos/large/' . $fname, $options = array());
                                $resize->resize(1000);
                                $resize->save('public/images/produtos/large/'.$fname);
                            }
                            
                            // $small = $thumbnailer->create('public/images/produtos/large/' . $fname, $options = array());
                            // $small->resize(212,159);
                            // $small->adaptiveResize(212,159);
                            // $small->save('public/images/produtos/small/'.$fname);
                            
                            // ///////////////////////////////////////////////////////////////////////////////////////////////
                            
                            // $thumbsmall = $thumbnailer->create('public/images/produtos/large/' . $fname, $options = array());
                            // $thumbsmall->resize(86,102);
                            // $thumbsmall->save('public/images/produtos/thumb_small/'.$fname);
                            
                            // ///////////////////////////////////////////////////////////////////////////////////////////////
                            
                            // $thumb = $thumbnailer->create('public/images/produtos/large/' . $fname, $options = array());
                            // $thumb->resize(50,66);
                            // $thumb->save('public/images/produtos/thumb/'.$fname);
                            
                            $names[] = $fname;
                        }                        
                    }
                    
                    unset($data['foto']);
                    $data = array_merge($noFile, array('foto' => $names));
                }
                
                $service = $this->getServiceLocator()->get("Produto\Service\Produto");
                $idproduto = $service->insert($data);
            } else {
                echo "<pre>", print_r($form->getMessages()), "</pre>";
                exit('nao passou validacao');
            }
            #exit;            
            return $this->redirect()->toRoute('admin-produto-home/admin-default', array('action' => 'crop','id' => $idproduto));
        }
    }

    public function cropAction ()
    {
        $idproduto = $this->params()->fromRoute('id', 0);
        $repositor = $this->getServiceLocator()->get("Produto\Repository\Produtos");
        $produto = $repositor->find($idproduto);        
        $size = getimagesize("public/images/produtos/large/{$produto->getFoto()}");
        
        
        $request = $this->getRequest();
        if($request->isPost())
        {
        	$data = $request->getPost()->toArray();
        	
        	/*
        	$imagename = explode('.', $data['imagem']);        	
        	$targ_w = $data['w'];
        	$targ_h = $data['h'];
        	$jpeg_quality = 90;
        	
        	$src = $request->getServer()->DOCUMENT_ROOT . '/seletoLoja/public/images/produtos/large/'.$data['imagem']; 
        	$img_r = imagecreatefromjpeg($src);
        	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
        	
        	imagecopyresampled($dst_r,$img_r,0,0,$data['x'],$data['y'],$targ_w,$targ_h,$data['w'],$data['h']);
        	
        	header('Content-type: image/jpeg');
        	imagejpeg($dst_r,null,$jpeg_quality);
        	*/
        	
        	#$nameimage = explode(".", $data['imagem']);
        	#$newname = md5(time().rand(0,2000)).'.'.$nameimage[1];
        	
        	$thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
        	$newimage = $thumbnailer->create('public/images/produtos/large/' . $data['imagem'], $options = array());
        	$newimage->crop($data['x'],$data['y'],$data['w'],$data['h']);
        	$newimage->save('public/images/produtos/large/'.$data['imagem']);
            
        	       	
        	$small = $thumbnailer->create('public/images/produtos/large/' . $data['imagem'], $options = array());        	
        	$small->resize(212,159);
        	$small->save('public/images/produtos/small/'.$data['imagem']);
        	
        	// ///////////////////////////////////////////////////////////////////////////////////////////////
        	
        	$thumbsmall = $thumbnailer->create('public/images/produtos/large/' . $data['imagem'], $options = array());
        	$thumbsmall->resize(86,102);
        	$thumbsmall->save('public/images/produtos/thumb_small/'.$data['imagem']);
        	
        	// ///////////////////////////////////////////////////////////////////////////////////////////////
        	
        	$thumb = $thumbnailer->create('public/images/produtos/large/' . $data['imagem'], $options = array());
        	$thumb->resize(50,66);
        	$thumb->save('public/images/produtos/thumb/'.$data['imagem']);
            
        	#return $this->redirect()->toRoute('admin-produto-home/admin-default', array('action' => 'crop','id' => $idproduto));
        	return $this->redirect()->toRoute('admin-produto-home');
        }
        
        
        return new ViewModel(array(
            'produto' => $produto,
            'width' => $size[0],
            'height' => $size[1],
        ));
    }

    public function editarAction ()
    {}

    public function gravarAlteracaoAction ()
    {}

    public function excluirAction ()
    {
        $service = $this->getServiceLocator()->get("Produto\Service\Produto");
        if ($service->delete($this->params()->fromRoute('id', 0))) {
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
        }
    }
    
}