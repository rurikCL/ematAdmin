<?php

class EmatadminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function creaunalumnoAction()
    {
        // action body
        //crea alumno en tblacceso
        //configuración inicial
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_LISTA=$this->_request->getPost('creaunalumnop1');
        $S_RUT= $this->_request->getPost('creaunalumnop2');
        $S_NOMBRE= $this->_request->getPost('creaunalumnop3');
        $S_COLEGIO= $this->_request->getPost('creaunalumnop4');
        $S_RUTTUTOR= $this->_request->getPost('creaunalumnop5');
        //
        //
        if(trim($S_RUT)!="" && trim($S_NOMBRE)!="" && trim($S_LISTA)!=""  && trim($S_COLEGIO)!="" && trim($S_RUTTUTOR)!="")
         {


                $sql = "select * from tblacceso where rut= '$S_RUT'  ";

                $rowset = $DB->fetchAll($sql);

                if (count($rowset) > 0)    // existe
                   {
                       echo "20,Alumno ($S_RUT) ya existe intente con otro";
                   }
                else      // creo el alumno
                   {
                        //
                        $S_AUX = explode("-",$S_LISTA);
                        $S_CURSO = $S_AUX[0];
                        $S_PASSWORD=rand(100,999);

                        $data = array(
                              'rut'      => $S_RUT,
                              'nombre' => $S_NOMBRE,
                              'lista'      => $S_LISTA,
                              'fechaingreso' => date("Y-m-d h:m:s"),
                              'curso' => $S_CURSO,
                              'institucion' => $S_COLEGIO,
                              'ultimomodulo' => 'no empieza aun',
                              'marca' => 0,
                              'datosreinic' => '',
                              'clave'=> $S_PASSWORD,
                              'ruttutor'=> $S_RUTTUTOR 
                              );
                         try
                            {
                             $DB->insert('tblacceso', $data);
                             echo("100,Alumno creado");
                            }
                         catch (Exception $e)
                            {
                              echo ("20,no graba ".$e->getMessage());
                            }
                   }

         }
    }

    public function creauntutorAction()
    {
        // action body
        //crea tutor en tblacceso   y tbltutores
        //configuración inicial
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_COLEGIO=$this->_request->getPost('creauntutorp1');
        $S_RUT= $this->_request->getPost('creauntutorp2');
        $S_NOMBRE= $this->_request->getPost('creauntutorp3');
        $S_MAIL= $this->_request->getPost('creauntutorp4');
        //
        //
        if(trim($S_RUT)!="" && trim($S_NOMBRE)!="" && trim($S_COLEGIO)!="")
         {


                $sql = "select * from tblacceso where rut= '$S_RUT' and institucion='$S_COLEGIO' ";

                $rowset = $DB->fetchAll($sql);

                if (count($rowset) > 0)    // existe
                   {
                       echo "20,Tutor ($S_RUT) ya existe intente con otro";
                   }
                else      // creo el tutor
                   {
                        //

                        $S_PASSWORD=rand(100,999);
                        $data = array(
                              'rut'      => $S_RUT,
                              'nombre' => $S_NOMBRE,
                              'lista'      => '',
                              'fechaingreso'      => date("Y-m-d h:m:s"),
                              'curso' => 'otro',
                              'institucion' => $S_COLEGIO,
                              'ultimomodulo' => 'no empieza aun',
                              'marca' => 0,
                              'datosreinic' => '',
                              'clave'=> $S_PASSWORD
                              );
                         $data1 = array(
                              'ruttutor'      => $S_RUT,
                              'nombretutor' => $S_NOMBRE,
                              'mailtutor'      => $S_MAIL,
                              'institucion' => $S_COLEGIO);

                         $result=true;

                         try
                            {
                             $DB->getConnection();
                             $DB->beginTransaction();
                             $DB->insert('tblacceso', $data);
                             $DB->insert('tbltutores', $data1);
                             $DB->commit();
                             echo("100,Tutor creado");
                            }
                         catch (Exception $e)
                            {
                              $DB->rollBack();
                              $result=false;
                              echo ( "20,no graba ".$e->getMessage());
                            }
                   }

         }
    }

    public function creauncolegioAction()
    {

            $this->_helper->layout->disableLayout();
            $config = Zend_Registry::get('config');
    
            $DB = Zend_Db_Table::getDefaultAdapter();
    
            $S_RBD=$this->_request->getPost('creauncolegiop1');
            $S_NOMBRE=$this->_request->getPost('creauncolegiop2');
    
            if(trim($S_RBD)!="" && trim($S_NOMBRE)!="")
            {
    
    
                            $sql = "select * from tblinstituciones where (institucion='$S_RBD' or RBD='$S_RBD') ";
                            //
                            $rowset = $DB->fetchAll($sql);
            
                            if (count($rowset) > 0)    // existe
                            {
                                   echo "20,Institucion ($S_RBD) ya existe intente con otra";
                            }
                            else     
                            {
                                            //creo institución
                
                                            $data = array('institucion' => $S_RBD,
                                                  'nombreinstitucion' => $S_NOMBRE,
                                                  'administradores' => '10',
                                                  'tipo'=> '0',
                                                  'RBD' => $S_RBD);
                                    
            
                                             $result=true;
            
                                             try
                                                {
                                                 $DB->getConnection();
                                                 $DB->beginTransaction();
                                                 $DB->insert('tblinstituciones', $data);
                                                 $DB->commit();
                                                 echo("100,Institucion creada");
                                                }
                                             catch (Exception $e)
                                                {
                                                  $DB->rollBack();
                                                  $result=false;
                                                  echo ("20,no graba ".$e->getMessage());
                                                }
                              }
    
             }


    }




    public function creasessionAction()
    {
        
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');

        $DB = Zend_Db_Table::getDefaultAdapter();

        $S_TUTOR=$this->_request->getPost('creasessionp1');
        $S_LISTA=$this->_request->getPost('creasessionp2');
        $S_SESSION=$this->_request->getPost('creasessionp3');
        $S_INSTITUCION=$this->_request->getPost('creasessionp4');

        if(trim($S_SESSION)=="")
          $S_SESSION="-";


        if(trim($S_TUTOR)!="" && trim($S_LISTA)!="" && trim($S_INSTITUCION)!="")
        {


                //identificar si es tutor
        
                $SQL="SELECT
                        t.ruttutor,
                        a.lista
                        FROM
                        tbltutores t
                        INNER JOIN tblacceso a ON t.ruttutor=a.ruttutor
                        WHERE
                        t.ruttutor='$S_TUTOR' and a.lista='$S_LISTA'";
        
                $rowset = $DB->fetchAll($SQL);
                if (count($rowset) > 0)
                {
                
                        //identificar que no tenga una session creada
                        $SQL_2="SELECT ruttutor FROM sesiones WHERE ruttutor='$S_TUTOR' and lista='$S_LISTA' and institucion='$S_INSTITUCION'";
                        $rowset_2 = $DB->fetchAll($SQL_2);
                        if (count($rowset_2) > 0)
                        {
                                echo "20,ya existe una session creada para esta lista";
            
                        }else{
                        
        
                                    //inicio sumando 1 hora 15 minutos
                                    $fecha=time();
                                    //la hora
								    $fecha += (1 * 60 * 60);
                                    //los 15 minutos
									$fecha += (15 * 60);
                                    									
									$fecha = date("Y-m-d H:i:s", $fecha);
                                    //fin sumando 1 hora 15 minutos
                
                                    $data = array('ruttutor' => $S_TUTOR,
                                          'fechahorainicio' => date("Y-m-d H:i:s"),
                                          'fechahoratermino' => $fecha,
                                          'idsesion'=> $S_SESSION,
                                          'lista' => $S_LISTA,
                                          'institucion' => $S_INSTITUCION);
                            
        
                                     $result=true;
        
                                     try
                                        {
                                         $DB->getConnection();
                                         $DB->beginTransaction();
                                         $DB->insert('sesiones', $data);
                                         $DB->commit();
                                         echo("100,session creada|".$fecha);
                                        }
                                     catch (Exception $e)
                                        {
                                          $DB->rollBack();
                                          $result=false;
                                          echo ("20,no graba ".$e->getMessage());
                                        }
        
        
        
        
                        }
        
                }else{
                    
                         echo "20,No existe el tutor asociado a la lista";
                
                }


        }else{
                    
                         echo "20,faltan parámetros";
                
             }


    }


    public function verificasessionAction()
    {
        
        
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');

        $DB = Zend_Db_Table::getDefaultAdapter();

        $S_RUTALUMNO=$this->_request->getPost('verificasessionp1');



        if(trim($S_RUTALUMNO)!="")
        {


                //identificar si es tutor
                $SQL="SELECT
                    s.ruttutor,
                    s.lista,
                    s.idsesion,
                    s.fechahorainicio,
                    s.fechahoratermino,
                    CAST((s.fechahorainicio+0) AS UNSIGNED) as fecha_inicio,
                    CAST((s.fechahoratermino+0) AS UNSIGNED) as fecha_termino 
                    FROM
                    tblacceso t
                    INNER JOIN sesiones s ON t.ruttutor=s.ruttutor and t.lista=s.lista and t.institucion=s.institucion  
                    WHERE
                    t.rut='$S_RUTALUMNO'";
        

        
                $rowset = $DB->fetchAll($SQL);
                if (count($rowset) > 0)
                {

                         $FECHA_HORA_ACTUAL=date("YmdHis");
                         $HORA_ACTUAL=date("Y-m-d H:i:s");
                            
    
                         foreach ($rowset as $fila)
                         {  

                            //echo $FECHA_HORA_ACTUAL."|".floatval($fila["fecha_inicio"])."|".floatval($fila["fecha_termino"]);

                            if(floatval($FECHA_HORA_ACTUAL)>=floatval($fila["fecha_inicio"]) && floatval($FECHA_HORA_ACTUAL)<=floatval($fila["fecha_termino"]))
                            {
                            
                                echo "100,".$fila["ruttutor"]."~".$fila["lista"]."~".$fila["idsesion"]."~".$fila["fechahorainicio"]."~".$fila["fechahoratermino"]."~".$HORA_ACTUAL;

                            }else{
                            
                                 echo "21, No se encuentra en el rango de tiempo de la sesion creada para el alumno ";
                            
                            }

                         }  
                        
                }else{
                    
                         echo "20,No existe una sesion creada para el alumno";
                
                }


        }else{
                    
                         echo "20,faltan parametros";
                
             }


        
   
    }

    public function verificasesiontutorAction()
    {


        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');

        $DB = Zend_Db_Table::getDefaultAdapter();

        $S_RUTTUTOR=$this->_request->getPost('verificasesiontutorp1');
        $S_LISTA=$this->_request->getPost('verificasesiontutorp2');
        $S_INSTITUCION=$this->_request->getPost('verificasesiontutorp3');


        if(trim($S_RUTTUTOR)!="" && trim($S_LISTA)!="" && trim($S_INSTITUCION)!="")
        {


                //identificar si es tutor
                $SQL="SELECT
                    s.ruttutor,
                    s.lista,
                    s.idsesion,
                    s.fechahorainicio,
                    s.fechahoratermino,
                    CAST((s.fechahorainicio+0) AS UNSIGNED) as fecha_inicio,
                    CAST((s.fechahoratermino+0) AS UNSIGNED) as fecha_termino 
                    FROM
                    tblacceso t
                    INNER JOIN sesiones s ON t.rut=s.ruttutor and t.institucion=s.institucion  
                    WHERE
                    t.rut='$S_RUTTUTOR' and 
                    s.lista='$S_LISTA' and 
                    t.institucion='$S_INSTITUCION' ";
        
                
        
                $rowset = $DB->fetchAll($SQL);
                if (count($rowset) > 0)
                {

                         $FECHA_HORA_ACTUAL=date("YmdHis");
                         $HORA_ACTUAL=date("Y-m-d H:i:s");
                            
    
                         foreach ($rowset as $fila)
                         {  

                            //echo $FECHA_HORA_ACTUAL."|".floatval($fila["fecha_inicio"])."|".floatval($fila["fecha_termino"]);

                            if(floatval($FECHA_HORA_ACTUAL)>=floatval($fila["fecha_inicio"]) && floatval($FECHA_HORA_ACTUAL)<=floatval($fila["fecha_termino"]))
                            {
                            
                                echo "100,".$fila["ruttutor"]."~".$fila["lista"]."~".$fila["idsesion"]."~".$fila["fechahorainicio"]."~".$fila["fechahoratermino"]."~".$HORA_ACTUAL;

                            }else{
                            
                                 echo "21, No se encuentra en el rango de tiempo de la sesion creada para el tutor ";
                            
                            }

                         }  
                        
                }else{
                    
                         echo "20,No existe una sesion creada para el tutor";
                
                }


        }else{
                    
                         echo "20,faltan parámetros";
                
             }


        
  
    }


}