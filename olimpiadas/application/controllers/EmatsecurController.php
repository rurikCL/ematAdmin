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
                $sql = "SELECT a.nombre as nombre,a.lista as lista,a.curso as curso,b.nombreinstitucion  FROM tblacceso a, tblinstituciones b WHERE a.rut ='$S_ID' and a.clave = '$S_CLAVE' and a.institucion = b.institucion";
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
                                        $COLEGIO =  trim($fila["nombreinstitucion"]);
                                    }

                        echo "100|".trim($NOMBRE_ALUMNO)."|".$LISTA."|".$CURSO."|".$COLEGIO."|";

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
                $sql = "SELECT a.nombre as nombre,b.nombreinstitucion FROM tblacceso a,tblinstituciones b WHERE a.rut ='$S_ID' and a.clave = '$S_CLAVE' and a.institucion = '$S_INSTITUCION'  and a.institucion = b.institucion ";
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
                                        $COLEGIO =  trim($fila["nombreinstitucion"]);
                                    }

                        echo "100|".trim($NOMBRE_TUTOR)."|".$a."|".$COLEGIO."|";

                }else{
                        echo "-1";
                     }



          }

    }


}







