<?php

class EmatoperController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function estadoactividadAction()
    {
        //revisa en que esta el alumno, si tiene un modulo o actividad inconclusa o no
        // action body
        //requiere layout activado en aplication ini
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
        $S_RUT=$this->_request->getPost('festadoactividadp1');
        $S_ACTIVIDAD=$this->_request->getPost('festadoactividadp2');
        //
        if(trim($S_RUT)!="" && trim($S_ACTIVIDAD)!="")
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
                
                $sql = "select ultimomodulo,marca,datosreinic from tblacceso where rut = '$S_RUT' ";
                //echo ($sql);
                $rowset = $DB->fetchRow($sql);
                //print_r($rowset);
                //echo (" marca ".$rowset["marca"]);
                $sql1 = "select puntaje as puntaje,termino as termino from tblregistro   where rut = '$S_RUT' and modulo =  '$S_ACTIVIDAD' and TRIM(estado) = 'terminado' ";
                //$sql1 = "select puntaje,termino  from tblregistro   where rut = '$S_RUT' and modulo =  '$S_ACTIVIDAD'  ";
                //echo ($sql1);
                //
                $bLibre = 0;
                $sInconclusa = "";
                $sDatosAct = "";
                if (count($rowset) > 0)
                   {
                      //echo("si   ");
                      if ($rowset["marca"] == 0)
                        {
                            //echo("-0X-");
                            $rowset1 = $DB->fetchRow($sql1);
                            //print_r($rowset1);
                            //echo(" count ".count($rowset1));
                            //exit;
                            if (count($rowset1) > 0)
                               {
                                $sDatosAct = trim($rowset1["puntaje"])."|".trim($rowset1["termino"])."|";
                               }
                            else
                               {
                                //echo ("1x");
                                $sDatosAct = "0|0"."|";
                               }
                        }
                      else   // hay una iniciada
                        {
                          //echo ("marca es 1");
                          $sReinicio = $rowset["datosreinic"];
                          if (stripos($sReinicio,$S_ACTIVIDAD)  === FALSE )   //  ' no  la encuentra, hay otra
                             {
                             $bLibre = 1;
                            //cual es la otra ?
                             $sInconclusa =  substr($sReinicio,0,4);
                             }
                          else // si la puede hacer , es la misma
                             {
                             //$sql1 = "select ingreso as ingreso from tblregistro   where rut = '$S_RUT' and modulo =  '$S_ACTIVIDAD' and TRIM(estado) = 'iniciado' ";
                             //$rowset1 = $DB->fetchAssoc($sql1);
                             //if (count($rowset1) > 0)
                               //{
                               // $sDatosAct = trim($rowset1["ingreso"]);
                               //}
                             //else
                               //{
                                //$sDatosAct = "Sin inicio";
                               //}
                             $bLibre = 2;
                             $sInconclusa =  $S_ACTIVIDAD;
                             //$sInconclusa =  $S_ACTIVIDAD."|".$sDatosAct."|";
                             }
                        }


                  }
                if ($bLibre == 0)
                    {
                     echo($bLibre."|".$sDatosAct);
                    }
                 else
                     {
                     echo($bLibre."|".$sInconclusa);
                     }
         }
    }

    public function insrtactividadAction()
    {
        //crea registro de actividad inicial en tblregistro, o actualiza si existe. ex inicio1p.asp
        //configuración inicial
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_INICIOS = $this->_request->getPost('Inicios');
        //print_r($S_INICIOS."<br>");
        //
        $parametros = explode("|", $S_INICIOS);
        //print_r($parametros);
        $S_RUT= $parametros[1];
        $S_ACTIVIDAD= $parametros[2];
        //echo("<br>".$S_RUT."<br>");
        //
        if(trim($S_RUT)!="" && trim($S_ACTIVIDAD)!="")
         {
                $Letra = strtolower(substr($S_ACTIVIDAD, 0, 1));
                switch ($Letra)
                       {
                       case "n":
                         $curso = "Naturales";
                         break;
                       case "d":
                         $curso = "Decimales";
                         break;
                       case "f":
                         $curso = "Fracciones";
                         break;
                       case "e":
                         $curso = "Enteros";
                         break;
                       case "p":
                         $curso = "Proporciones";
                         break;
                       case "s":
                         $curso = "Estadistica";
                         break;
                       case "m":
                         $curso = "Medida";
                         break;
                       case "g":
                         $curso = "Geometria 2d";
                         break;
                       case "t":
                         $curso = "Geometria 3d";
                         break;
                       default:
                          $curso = "Naturales";
                       }
                
                $sql = "select cuenta as cuenta from tblregistro where rut= '$S_RUT' and modulo = '$S_ACTIVIDAD' ";
                //echo ($sql."<br>");
                $rowset = $DB->fetchAll($sql);
                //echo("hay regs  ".count($rowset)."<br>");
                //print_r($rowset);
                if (count($rowset) > 0)    // existe
                   {
                       //echo ("<br>"."entro  si hay "."<br>");
                       foreach ($rowset as $fila)
                            {
                            $cuenta = $fila["cuenta"];
                            }
                       //$cuenta = $cuenta + 1;  solo al termino
                       $data = array(
                              'ingreso'      => date("Y-m-d H:i:s"),
                              'estado' => 'iniciado',
                              'cuenta' => $cuenta
                              );
                       $where[]= "rut = '$S_RUT'";
                       $where[]= "modulo = '$S_ACTIVIDAD'";
                       $n = $DB->update('tblregistro', $data, $where);
                   }
                else      // inserto
                   {
                        //echo ("<br>"."si voy a grabar ". $S_RUT." ".$S_ACTIVIDAD."<br>");
                        $cuenta = 0;
                        $data = array(
                              'rut'      => $S_RUT,
                              'curso' => $curso,
                              'modulo'      => $S_ACTIVIDAD,
                              'ingreso'      => date("Y-m-d H:i:s"),
                              'cuenta' => $cuenta,
                              'estado' => 'iniciado'
                              );
                         try
                            {
                             $DB->insert('tblregistro', $data);
                             echo("100");
                            }
                          catch (Exception $e)
                            {
                              echo ( "no graba ".$e->getMessage());
                            }
                   }

         }
    }

    public function updateactividadAction()
    {
        //termina actividad  en tblregistro y actualiza ultimomodulo..... ex modulotermino1p.asp
        // action body
        $this->_helper->layout->disableLayout();

         //configuración inicial
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_INICIOS = $this->_request->getPost('Terminos');
        //
        $parametros = explode("|", $S_INICIOS);
        $S_RUT= $parametros[1];
        $S_ACTIVIDAD= $parametros[2];
        $S_PUNTAJE = $parametros[3];
        if(trim($S_PUNTAJE) == "")
           {
             $S_PUNTAJE = 100;
           }
        //
        if(trim($S_RUT)!="" && trim($S_ACTIVIDAD)!="")
         {
                $Letra = strtolower(substr($S_ACTIVIDAD, 0, 1));
                switch ($Letra)
                       {
                       case "n":
                         $curso = "Naturales";
                         break;
                       case "d":
                         $curso = "Decimales";
                         break;
                       case "f":
                         $curso = "Fracciones";
                         break;
                       case "e":
                         $curso = "Enteros";
                         break;
                       case "p":
                         $curso = "Proporciones";
                         break;
                       case "s":
                         $curso = "Estadistica";
                         break;
                       case "m":
                         $curso = "Medida";
                         break;
                       case "g":
                         $curso = "Geometria 2d";
                         break;
                       case "t":
                         $curso = "Geometria 3d";
                         break;
                       default:
                          $curso = "Naturales";
                       }
                
                $sql = "select * from tblregistro where rut= '$S_RUT' and modulo = '$S_ACTIVIDAD' ";
                //echo ($sql);
                $rowset = $DB->fetchAll($sql);
                //print_r($rowset);
                if (count($rowset) > 0)    // existe inicio
                   {
                       foreach ($rowset as $fila)
                            {
                             $cuenta = $file["cuenta"];
                            }
                       $cuenta = $cuenta + 1;
                   }
                else      // no existe inicio, lo creo
                   {
                        //echo ("no existe inicio");
                        $cuenta = 0;
                        $data = array(
                              'rut'      => $S_RUT,
                              'curso' => $curso,
                              'modulo'      => $S_ACTIVIDAD,
                              'ingreso'      => date("Y-m-d H:i:s"),
                              'cuenta' => $cuenta,
                              'estado' => 'iniciado'
                              );
                        $DB->insert('tblregistro', $data);
                   }
                  //actualizo todo
                  $DB->beginTransaction();
                  try {
                            // tblregistro
                            //echo ("voy a actualizar ");
                            $data = array(
                              'termino'      => date("Y-m-d H:i:s"),
                              'estado' => 'terminado',
                              'hecho' => '1',
                              'puntaje' => $S_PUNTAJE,
                              'cuenta' => $cuenta
                              );
                            $where['rut = ?' ] =  $S_RUT;
                            $where['modulo = ?']= $S_ACTIVIDAD;
                            $DB->update ('tblregistro', $data, $where);

                             //Actualiza el campo ultimo modulo
                            // tblacceso

                            $data1 = array(
                              'FechUltMod'  => date("Y-m-d H:i:s"),
                              'ultimomodulo' => $S_ACTIVIDAD,
                              'marca' => '0',
                              'datosreinic' => ''
                              );
                             $where1['rut = ?' ] =  $S_RUT;
                             $n = $DB->update('tblacceso', $data1, $where1);
                             $DB->commit();
                             echo ("100");
                            }
                   catch (Exception $e)
                             {
                                $DB->rollBack();
                                echo $e->getMessage();
                             }
         }
    }

    public function reinicioAction()
    {
        // action body
        $this->_helper->layout->disableLayout();
         //crea campos / actualiza si existe. los datos de reinicio de la app (marca,datosreinic) en tblacceso
        //configuración inicial
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_INICIOS = $this->_request->getPost('Reinicio');
        //
        $parametros = explode("|", $S_INICIOS);
        $S_RUT= $parametros[1];
        $S_DatosReinicio= $parametros[2];
        //echo($S_RUT."<br>");
        //echo($S_DatosReinicio."<br>");
        //
        if(trim($S_RUT)!="" )
         {
              if(trim($S_DatosReinicio)  == "" )
                   {
                     //lee reinicio
                     $sql = "select marca,datosreinic from tblacceso where rut = '$S_RUT' ";
                     //echo ($sql."<br>");
                     try
                        {
                         $rowset = $DB->fetchRow($sql);
                         //$rowset = $DB->fetchAssoc($sql);
                         //print_r($rowset);
                         if ($rowset["marca"] == 0)
                                 {
                                  echo ("0");
                                 }
                         else
                                 {
                                  //print_r($rowset);
                                  echo ($rowset["datosreinic"]);
                                  }
                         }
                     catch (Exception $e)
                         {
                          echo ("20|0|0");
                         }
                   }
               else
                   {
                     //graba reinicio
                     echo("graba reinicio ".$S_DatosReinicio);
                     try {
                           $data = array(
                              'FechUltMod'      => date("Y-m-d"),
                              'marca' => '1',
                              'datosreinic' => $S_DatosReinicio
                              );
                           $where['rut = ?']= $S_RUT;
                           $n = $DB->update('tblacceso', $data, $where);
                           echo ("100");
                         }
                     catch (Exception $e)
                         {
                           echo ( "21".$e->getMessage());
                         }
                   }
         }
    }

    public function leesreinicioAction()
    {
        //lee datos de reinicio de la aplicacion
        // action body
        $this->_helper->layout->disableLayout();
        $config = Zend_Registry::get('config');
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //con parametros
        $S_INICIOS = $this->_request->getPost('LeeReinicio');
        //
        //echo $S_INICIOS;
        $parametros = explode("|", $S_INICIOS);
        $S_RUT= $parametros[1];
        //echo($S_RUT."<br>");
        //
        if(trim($S_RUT)!="" )
         {
              
                     //lee reinicio
                     $sql = "select marca,datosreinic from tblacceso where rut = '$S_RUT' ";
                     //echo ($sql."<br>");
                     try
                        {
                         $rowset = $DB->fetchRow($sql);
                         //print_r($rowset);
                         //echo $rowset["marca"];
                         if ($rowset["marca"] == 0)
                                 {
                                  echo ("0");
                                  //exit;
                                 }
                         else
                                 {
                                  //print_r($rowset);
                                  echo ($rowset["datosreinic"]);
                                  }
                         }
                     catch (Exception $e)
                         {
                          echo ("20|0|0");
                         }                  
               
         }

    }


}











