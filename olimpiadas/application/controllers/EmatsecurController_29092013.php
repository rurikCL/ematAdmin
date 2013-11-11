<?php

class EmatsecurController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function conexionAction()
    {
        // action body
        // requiere layout activado en aplication ini
        $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        // echo "si  entro";
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        
        //PARAMETROS
        $S_ID=$this->_request->getPost('fconexionp1');
        $S_CLAVE=$this->_request->getPost('fconexionp2');
        
        //con parametros

        if(trim($S_ID)!="" && trim($S_CLAVE)!="")
        {
                //echo "si hay datos";
                $sql = "SELECT nombre as nombre,lista as lista,curso as curso FROM tblacceso WHERE rut ='$S_ID' and clave = '$S_CLAVE' ";
                $rowset = $DB->fetchAll($sql);
                    
                if (count($rowset) > 0)
                {
                        //$a = session_id();
                        echo("3");
                        //Zend_Registry::set('session', $session);
                        //$session->loginok = $a;

                        $NOMBRE_ALUMNO="";
                        $LISTA = "";
                        foreach ($rowset as $fila)
                                    {
                                        $NOMBRE_ALUMNO=trim($fila["nombre"]);
                                        $LISTA =  trim($fila["lista"]);
                                        $CURSO =  trim($fila["curso"]);
                                    }

                        echo "100|".trim($NOMBRE_ALUMNO)."|".$LISTA."|".$CURSO."|";

                }else{
                        echo "-1";
                     }



          }

    }

    public function olvidapassAction()
    {
        // action body
    }

    public function conexiontutorAction()
    {
        // action body
        // action body
        // requiere layout activado en aplication ini
        $this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuración inicial
        // echo "si  entro";
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        
        //PARAMETROS
        $S_ID=$this->_request->getPost('fconexiontutorp1');
        $S_CLAVE=$this->_request->getPost('fconexiontutorp2');
        $S_INSTITUCION=$this->_request->getPost('fconexiontutorp3');
        //con parametros

         $session = new Zend_Session_Namespace('OLIMPIADAS');

        if(trim($S_ID)!="" && trim($S_CLAVE)!="")
        {
                //echo "si hay datos";
                $sql = "SELECT nombre as nombre FROM tblacceso WHERE rut ='$S_ID' and clave = '$S_CLAVE' and institucion = '$S_INSTITUCION' ";
                //echo $sql;
                $rowset = $DB->fetchAll($sql);
                    
                if (count($rowset) > 0)
                {
                        $a = session_id();
                        //echo("3");
                        Zend_Registry::set('session', $session);
                        $session->loginok = $a;

                        $NOMBRE_TUTOR="";
                        foreach ($rowset as $fila)
                                    {
                                        $NOMBRE_TUTOR=trim($fila["nombre"]);
                                    }

                        echo "100|".trim($NOMBRE_TUTOR)."|".$a."|";

                }else{
                        echo "-1";
                     }



          }

    }


}







