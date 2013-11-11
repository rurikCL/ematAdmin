<?php

class EmatrepolimpiadasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function resultadoscursoAction()
    {
         //saca listas de actividades realizadas por un curso
        // action body
        // requiere layout activado en aplication ini
        //$this->_helper->layout->disableLayout();
        //echo "voy bien 1";
        //configuraci�n inicial
        $config = Zend_Registry::get('config');
        //echo "voy bien 2";
        //CONEXION
        $DB = Zend_Db_Table::getDefaultAdapter();
        //echo "voy bien 3";
        

        //PARAMETROS

        $S_CODCOL=$this->_request->getParam('codigoColegio');
        $S_CODLISTA = $this->_request->getParam('codigoLista');
        $S_TIPOUSUARIO = $this->_request->getParam('tipoUsuario');

		if(trim($S_CODCOL)!="" && trim($S_CODLISTA)!="" )
         {
                $sql = "select count(rut) as inscritos from olimpiadas.tblacceso where institucion = $S_CODCOL and lista = '$S_CODLISTA';";
                 $rowset = $DB->fetchAll($sql);
                 //print_r($rowset);
                 if (count($rowset) > 0)
                 {
                     $equipos = $rowset[0]['inscritos'];
                 }else{
                     $equipos = 0;
                 }
                $sql = "Select a.nombre,a.curso, date_format(r.termino,'%H:%i') as hora, r.puntaje, d.*
                        from tblregistro r, tblacceso a, tbldetallecursos d
						where a.rut = r.rut and r.modulo = d.modulo and a.institucion = $S_CODCOL and a.lista = '$S_CODLISTA' and (r.termino <> '' and r.termino is not null)";
				
                 //echo($sql);
                 try{
                           $rowset = $DB->fetchAll($sql);
                           //print_r($rowset);
                           if (count($rowset) > 0)
                           {
                               $puntos_acumulados = 0;
                               $multiplier = 0;
                               $vector_datos = array();

                               foreach($rowset as $key => $val){
                                   switch ($val['curso']){
                                       case '3 BASICO' : $multiplier = 500 + ($val['tercero'] * 500); break;
                                       case '4 BASICO' : $multiplier = 500 + ($val['cuarto'] * 500); break;
                                       case '5 BASICO' : $multiplier = 500 + ($val['quinto'] * 500); break;
                                       case '6 BASICO' : $multiplier = 500 + ($val['sexto'] * 500); break;
                                       case '7 BASICO' : $multiplier = 500 + ($val['septimo'] * 500); break;
                                       case '8 BASICO' : $multiplier = 500 + ($val['octavo'] * 500); break;
                                       case 'I MEDIO' : $multiplier = 500 + ($val['primero_medio'] * 500); break;
                                       case 'II MEDIO' : $multiplier = 500 + ($val['segundo_medio'] * 500); break;
                                       case 'III MEDIO' : $multiplier = 500 + ($val['tercero_medio'] * 500); break;
                                       case 'IV MEDIO' : $multiplier = 500 + ($val['cuarto_medio'] * 500); break;
                                   }

                                   $puntos = ($val['puntaje'] * $multiplier) / 100;
                                   $puntos_acumulados+= $puntos;

                                   $vector_datos[] =  array(
                                           "nombre" => $val['nombre'],
                                           "descripcion" => $val['descripcion'],
                                           "hora" => $val['hora'],
                                           "puntaje" => round($val['puntaje'],1),
                                           "puntos" => $puntos,
                                   );


                               }
                               Zend_Layout::getMvcInstance()->assign('actcol',$vector_datos);
                               Zend_Layout::getMvcInstance()->assign('puntaje',round($puntos_acumulados / $equipos,1));
                               Zend_Layout::getMvcInstance()->assign('equipos',$equipos);
                               Zend_Layout::getMvcInstance()->assign('usuario',$S_TIPOUSUARIO);
                           }

                 }
                 catch (Zend_Exception $e)
                        {
                           echo $e->getMessage();
                        }
          }
      else
          {
            $this->_helper->layout->disableLayout();
            echo "-1";
          }

    }

    public function rankingolimpiadasAction()
    {
        // action body

        $config = Zend_Registry::get('config');
        $DB = Zend_Db_Table::getDefaultAdapter();

        //PARAMETROS

        $S_ZONA = $this->_request->getParam('zona');
        $S_CODLISTA = $this->_request->getParam('codigoLista');
        $identificador_curso = ""; // nombre de columna en tabla de actividades

        if(trim($S_CODLISTA)!="" && trim($S_ZONA)!="" )
        {


                switch ($S_CODLISTA){
                    case '3 BASICO' : $identificador_curso = "tercero"; break;
                    case '4 BASICO' : $identificador_curso = "cuarto"; break;
                    case '5 BASICO' : $identificador_curso = "quinto"; break;
                    case '6 BASICO' : $identificador_curso = "sexto"; break;
                    case '7 BASICO' : $identificador_curso = "septimo"; break;
                    case '8 BASICO' : $identificador_curso = "octavo"; break;
                    case 'I MEDIO' : $identificador_curso = "primero_medio"; break;
                    case 'II MEDIO' : $identificador_curso = "segundo_medio"; break;
                    case 'III MEDIO' : $identificador_curso = "tercero_medio"; break;
                    case 'IV MEDIO' : $identificador_curso = "cuarto_medio"; break;
                }

            $sql = "select h.institucion ,h.lista, t.nombretutor, h.nombreinstitucion as nombre, 
			(sum(h.acumulado) / f.alumnos) as puntaje
                    from
                        (select a.institucion, a.ruttutor, i.nombreinstitucion, a.lista, r.modulo, r.puntaje, case d.tercero when 0 then '0' else (r.puntaje * (500+(d.".$identificador_curso." * 500))) / 100 end as acumulado
                         from tblacceso a, tblregistro r, tblinstituciones i, tbldetallecursos d
                         where a.rut = r.rut and a.institucion = i.institucion and a.curso = '$S_CODLISTA' and r.modulo = d.modulo and r.puntaje is not null) h,
                          olimpiadas_base.colegios_inscritos c, tbltutores t, 
						  (select count(rut) as alumnos, lista, institucion from tblacceso group by institucion,lista) f 
                    where c.zona_nombre = '$S_ZONA' and h.ruttutor = t.ruttutor 
					AND h.institucion = f.institucion and h.lista = f.lista
                    group by h.lista, h.institucion
					order by puntaje desc";

            //echo($sql);
            try{
                $rowset = $DB->fetchAll($sql);
                //print_r($rowset);
                if (count($rowset) > 0)
                {
                    $lugar_ranking = 0;
                    $vector_datos = array();

                    foreach($rowset as $key => $val){
                        $lugar_ranking++;

                        $vector_datos[] =  array(
							"rbd" => $val['institucion'],
                            "lugar" => $lugar_ranking,
                            "nombre_colegio" => $val['nombre'],
                            "curso" => $val['lista'],
                            "tutor" => $val['nombretutor'],
                            "puntaje" => round($val['puntaje'],1),
                        );


                    }
                    Zend_Layout::getMvcInstance()->assign('actcol',$vector_datos);
                }

            }
            catch (Zend_Exception $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            $this->_helper->layout->disableLayout();
            echo "-1";
        }
    }


}
