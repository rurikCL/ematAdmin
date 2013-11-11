<?php

class EmatconsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function complementariasAction()
    {
        //saca listas de actividades complementarias
        // action body
        // requiere layout activado en aplication ini
        $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        

        //con parametros

        //PARAMETROS
        $S_CURSO=$this->_request->getPost('fcomplementariasp1');
        $S_TIPO=$this->_request->getPost('fcomplementariasp2');
        
        
        //$session = new Zend_Session_Namespace('EMATLOCAL');
                            
                    
        //con parametros
        if(trim($S_CURSO)!="" && trim($S_TIPO)!="")
         {
        
                /*
                $S_ID=$this->encrypt($S_ID,$keyStr);
                $S_CLAVE=$this->encrypt($S_CLAVE,$keyStr);
                */  
                //echo "$S_ID@@@$S_CLAVE<br>";
        
        
                // si los datos están encriptados
                // usamos encrypt
                //$S_ID=$functions->decrypt($S_ID,$keyStr);
                //$S_CLAVE=$functions->decrypt($S_CLAVE,$keyStr);
        
                //echo "$S_ID@@@$S_CLAVE<br>";
                
                $sql = "select descripcion as descripcion,modulo as modulo from tbldetallecursos where ";

                switch ($S_CURSO)
                       {
                       case "3 BASICO":
                            $sql = $sql." tercero = ".$S_TIPO." ";
                            break;
                       case "4 BASICO":
                            $sql = $sql." cuarto = ".$S_TIPO." ";
                            break;
                       case "5 BASICO":
                            $sql = $sql." quinto = ".$S_TIPO." ";
                            break;
                       case "6 BASICO":
                            $sql = $sql." sexto = ".$S_TIPO." ";
                            break;
                       case "7 BASICO":
                            $sql = $sql." septimo = ".$S_TIPO." ";
                            break;
                       case "8 BASICO":
                            $sql = $sql." octavo = ".$S_TIPO." ";
                            break;
                       case "I MEDIO":
                            $sql = $sql." primero_medio = ".$S_TIPO." ";
                            break;
                       default:
                            $sql = $sql." primero_medio = ".$S_TIPO." ";
                       }
                //
                //echo ($sql);
                $rowset = $DB->fetchAll($sql);
                //print_r($rowset);
                //
                if (count($rowset) > 0)
                    {
                      $vector = "";
                      $i = 0;
                      foreach ($rowset as $fila)
                           {
                            if ($i == 0)
                               {
                                $vector = trim($fila["descripcion"])."~".trim($fila["modulo"]);
                               }
                            else
                               {
                                $vector = $vector."*".trim($fila["descripcion"])."~".trim($fila["modulo"]);
                               }
                            $i = $i + 1;
                           }
                       echo $vector."*";

                    }
                else
                    {
                         echo "-1";
                    }


        //con sesion
        //}else if(isset($_SESSION["login-ok"]) && trim($_SESSION["login-ok"])!="") 
        }

        
    }

    public function veractivcursoAction()
    {
        //saca listas de actividades realizadas por un curso
        // action body
        // requiere layout activado en aplication ini
        $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        


        //con parametros

        //PARAMETROS
        $S_LISTA=$this->_request->getPost('veractivcursop1');

        
        
        //$session = new Zend_Session_Namespace('EMATLOCAL');
                            
                    
        //con parametros
        if(trim($S_LISTA)!="" )
         {
        
                /*
                $S_ID=$this->encrypt($S_ID,$keyStr);
                $S_CLAVE=$this->encrypt($S_CLAVE,$keyStr);
                */  
                //echo "$S_ID@@@$S_CLAVE<br>";
        
        
                // si los datos están encriptados
                // usamos encrypt
                //$S_ID=$functions->decrypt($S_ID,$keyStr);
                //$S_CLAVE=$functions->decrypt($S_CLAVE,$keyStr);
        
                //echo "$S_ID@@@$S_CLAVE<br>";
                //echo ($S_LISTA);
                $sql = "select a.rut,a.nombre,b.modulo,b.ingreso,b.termino,b.estado,b.puntaje
                        from tblacceso a,tblregistro b
                        where
                           a.rut = b.rut and
                           a.lista = '$S_LISTA'
                        order by a.nombre asc,b.termino desc";
                 //
                 //echo($sql);
                 try{
                           $rowset = $DB->fetchAll($sql);
                           //print_r($rowset);
                           if (count($rowset) > 0)
                           {

                                   Zend_Layout::getMvcInstance()->assign('actalum',$rowset);
                           }

                 }
                 catch (Zend_Exception $e)
                        {
                           echo $e->getMessage();
                        }


          }
      else
          {
            echo "-1";
          }


        //con sesion
        //}else if(isset($_SESSION["login-ok"]) && trim($_SESSION["login-ok"])!="") 
        //}

        
    }

    public function verunrutAction()
    {
        // action body
        //saca de un rut, sus datos en tblaccesp
        // requiere layout activado en aplication ini
        $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        


        //con parametros

        //PARAMETROS
        $S_RUT=$this->_request->getPost('verunrutp1');

        
        
        //$session = new Zend_Session_Namespace('EMATLOCAL');
                            
                    
        //con parametros
        if(trim($S_RUT)!="" )
         {
        
                /*
                $S_ID=$this->encrypt($S_ID,$keyStr);
                $S_CLAVE=$this->encrypt($S_CLAVE,$keyStr);
                */  
                //echo "$S_ID@@@$S_CLAVE<br>";
        
        
                // si los datos están encriptados
                // usamos encrypt
                //$S_ID=$functions->decrypt($S_ID,$keyStr);
                //$S_CLAVE=$functions->decrypt($S_CLAVE,$keyStr);
        
                //echo "$S_ID@@@$S_CLAVE<br>";
                //echo ($S_LISTA);
                $sql = "select rut,nombre,institucion,lista,ultimomodulo,marca,datosreinic
                        from tblacceso
                        where
                           rut = '$S_RUT'";
                 //
                 //echo($sql);
                 try{
                           $rowset = $DB->fetchAll($sql);
                           //print_r($rowset);
                           if (count($rowset) > 0)
                           {

                                   Zend_Layout::getMvcInstance()->assign('detallerut',$rowset);
                           }

                 }
                 catch (Zend_Exception $e)
                        {
                           echo $e->getMessage();
                        }


          }
      else
          {
            echo "-1";
          }


        //con sesion
        //}else if(isset($_SESSION["login-ok"]) && trim($_SESSION["login-ok"])!="") 
        //}

        
    }

    public function vernunequipAction()
    {
	 $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        // action body
		
		$S_RBD=$this->_request->getParam('rbd');
		$S_LISTA=$this->_request->getParam('lista');
		
		if($S_RBD!= ""){
			 $sql = "SELECT count(*) as cantidad FROM olimpiadas.tblacceso t where t.institucion = '$S_RBD' ";
                 
			 if($S_LISTA){
			 	$sql.="and t.lista = '$S_LISTA'";
			 }
                 //echo($sql);
                 try{
                           $rowset = $DB->fetchAll($sql);
                           //print_r($rowset);
                           if (count($rowset) > 0)
                           {
                                   Zend_Layout::getMvcInstance()->assign('cantidad',$rowset[0]['cantidad']);
                           }

                 }
                 catch (Zend_Exception $e)
                        {
                           echo $e->getMessage();
                        }


          }
      	else
          {
            echo "-1";
          }		
    }


} // Fin  clase











