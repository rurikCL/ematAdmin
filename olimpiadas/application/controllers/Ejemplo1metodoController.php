<?php

class OpergestionController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }


    public function fpto0208Action()
    {
        // Despliega gestiones Cliente
        // action body
        //$this->_helper->layout->disableLayout();
       // efectua una consulta (query o i8nstruccion sql) almacenada en tabla_consultas, la cual puede
       //                       venir o se parametrica, y devuelve los resultados como un tabla html
       //
       //actions
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
                        
        //PARAMETROS
        $S_SESSION=$this->_request->getPost('fpto0208p1');
        $S_RUTDEQUIEN=$this->_request->getPost('fpto0208p2');    // rut cliente
        
         //sessiones
        $session = new Zend_Session_Namespace('HILO'); 
                    
        //con parametros
        if(trim($S_RUTDEQUIEN)!=""  && trim($S_SESSION)!="")
        {
                
            if(isset($session->loginok) && trim($session->loginok)==trim($S_SESSION) )
            {
                            $sqlFecha = "SET lc_time_names = 'es_ES'";
                            $resultFecha = $DB->query($sqlFecha);
                            $sql = "select gestion,codgestion,DATE_FORMAT(fechacreacion,'%a %d, %b %Y') as fechacreacion,DATE_FORMAT(fechaactualizacion,'%a %d, %b %Y') as fechaactualizacion,resumen,estado,sentidoactual,nivelactual,sentido    from gestiones_hilo where rut = '$S_RUTDEQUIEN' order by codgestion desc";
                            //echo $sql;
                            $result = $DB->query($sql);

                            $CONT_FILAS=$result->rowCount();

                            if ($CONT_FILAS > 0)
                                    {
                                      $COUNT_FILES=0;

                                      try
                                         {

                                           $rowset = $DB->fetchAll($sql);
                                        
                                           //con esta sentencia mandamos variable rowset al view
                                           //fpto0208.phtml
                                           Zend_Layout::getMvcInstance()->assign('rowset',$rowset);
                                           //Zend_Layout::getMvcInstance()->assign('s_tipo',$S_TIPO);

                                          }

                                       catch (Zend_Exception $e)
                                           {
                                             echo $e->getMessage();
                                           }
                                    }
                            else
                                {
                                    
                                   /* action body */
                                           $this->_helper->layout->disableLayout();
                                                            
                                           //no tiene gestiones
                                           echo "-11";
                                            
                                 }


                   
                }else{
                        //session invalida o no existe
                        echo "-2";
                     }


        }else{
        
                    //si faltan parametros
                    echo "0";
        
             }
    


    }



}





























