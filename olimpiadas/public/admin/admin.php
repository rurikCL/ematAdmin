<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Administrador Olimpiadas</title>
    <link rel="stylesheet" href="css/css3-buttons.css" type="text/css"  media="screen">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Molengo' rel='stylesheet' type='text/css'>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

    <!-- Using TipTip jQuery plugin for the tooltips -->
    <link rel="stylesheet" href="css/tiptip.css" type="text/css"  media="screen">
    <link rel="stylesheet" href="css/adminStyle.css" type="text/css"  media="screen">
    <script src="jquery.tiptip.js"></script>
    <script src="adminJscript.js"></script>
<?php
include("../Connections/olimpiadas.php");
?>
</head>
<body>
<div id="container">

<!-- ************************ Opciones **************** -->

    <div id="divAlumnos" class="buttons"><h2>Opciones de Alumnos</h2>
        <span class="textoPequeno" style="float: right;">Ultimo rut consultado : <div id="divUltimoRut" class="textoPequeno">---</div></span>
        <a href="javascript:" class="button" id="b_verAlumno"><span class="icon icon191"></span><span class="label">Ver Alumno</span></a>
        <a href="javascript:" class="button" id="b_creaAlumno"><span class="icon icon191"></span><span class="label">Crear Alumno</span></a>
        <a href="javascript:" class="button" id="b_verSesionAlumno"><span class="icon icon116"></span><span class="label">Ver Sesion Alumno</span></a>


    </div> <!-- /.buttons -->

    <div id="divTutores" class="buttons"><h2>Opciones de Tutor</h2>
        <a href="javascript:" class="button" id="b_verTutor"><span class="icon icon4"></span><span class="label">Ver Tutor</span></a>
        <a href="javascript:" class="button" id="b_crearTutor"><span class="icon icon4"></span><span class="label">Crear Tutor</span></a>
        <a href="javascript:" class="button" id="b_verSesionTutor"><span class="icon icon116"></span><span class="label">Ver Sesion Tutor</span></a>
    </div> <!-- /.buttons -->


    <div id="divColegios" class="buttons"><h2>Opciones de Colegio</h2>
        <a href="javascript:" class="button" id="b_verColegios"><span class="icon icon108"></span><span class="label">Ver Colegios</span></a>
        <a href="javascript:" class="button" id="b_crearColegio"><span class="icon icon108"></span><span class="label">Crear Colegio</span></a>
        <a href="javascript:" class="button" id="b_actividadesCurso"><span class="icon icon120"></span><span class="label">Actividades Curso</span></a>

    </div> <!-- /.buttons -->

<!-- ************************ Inputs **************** -->

    <div id="divFields" class="buttons">
        <input id="inputRut" type="text" alt="Rut Alumno" class="field3">
        <input id="inputNombre" type="text" alt="Nombre Alumno" class="field3">

        <input id="inputRutTutor" type="text" alt="Rut Tutor" class="field3">
        <input id="inputNombreTutor" type="text" alt="Nombre Tutor" class="field3">

        <input id="inputDatosReinicio" type="text" alt="Datos de Reinicio" class="field3">
        <input id="inputLista" type="text" alt="Lista" class="field3">
        <input id="inputColegio" type="text" alt="Codigo Colegio" class="field3">
        <input id="inputNombreColegio" type="text" alt="Nombre Colegio" class="field3">

        <input id="inputMail" type="text" alt="E-mail" class="field3">

        <div id="divEjecutar" class="">
            <button id="b_ejecutor" class="action blue"><span class="label">Ejecutar</span></button>
            <!-- <button class="action red"><span class="label">Upload</span></button>
            <button class="action green"><span class="label">Comment</span></button> -->
            <button id="b_cancelar" class="action"><span class="label">Cancelar</span></button>
        </div> <!-- /.buttons -->
    </div>
<!-- ************************ Resultado **************** -->

    <div id="divResultado"></div>
</div>

</body>