$(document).ready(function() {

    // Toggle the dropdown menu's
    $(".dropdown .button, .dropdown button").click(function () {
        if (!$(this).find('span.toggle').hasClass('active')) {
            $('.dropdown-slider').slideUp();
            $('span.toggle').removeClass('active');
        }

        // open selected dropown
        $(this).parent().find('.dropdown-slider').slideToggle('fast');
        $(this).find('span.toggle').toggleClass('active');

        return false;
    });

    // Launch TipTip tooltip
    $('.tiptip a.button, .tiptip button').tipTip();


    // SEARCH INPUT (added)
    $(".field").keyup(function() {
        $(".x").fadeIn();
        if ($.trim($(".field").val()) == "") {
            $(".x").fadeOut();
        }
    });
    // on click of "X", delete input field value and hide "X"
    $(".x").click(function() {
        $(".field").val("");
        $(this).hide();
    });

    // ----------------------------------------------------------------------------------------
    //              INIT

    $("#divEjecutar").hide();
    $("#divUltimoRut").click(function(){
        if(ejecutorFlag != "" && $("#inputRut").is(':visible')){
            $("#inputRut").val($(this).html())
                .removeClass("borderRed");
        }
    });

    // --------------------------------------------------------
    //          Botones de Opciones

    $("#b_creaAlumno").click(function(){
        activaCampos("#inputLista,#inputRut,#inputNombre,#inputColegio,#inputRutTutor",$(this).attr('id'));
    });

    $("#b_verAlumno").click(function(){
        activaCampos("#inputRut",$(this).attr('id'));
    });

    $("#b_crearTutor").click(function(){
        activaCampos("#inputRutTutor,#inputColegio,#inputNombreTutor,#inputMail",$(this).attr('id'));
    });

    $("#b_verTutor").click(function(){
        activaCampos("#inputRutTutor",$(this).attr('id'));
    });
    $("#b_crearColegio").click(function(){
        activaCampos("#inputColegio,#inputNombreColegio",$(this).attr('id'));
    });
    $("#b_verSesionAlumno").click(function(){
        activaCampos("#inputRut",$(this).attr('id'));
    });
    $("#b_verSesionTutor").click(function(){
        activaCampos("#inputRutTutor,#inputColegio,#inputLista",$(this).attr('id'));
    });
    $("#b_actividadesCurso").click(function(){
        activaCampos("#inputColegio,#inputLista",$(this).attr('id'));
    });



//   ----------------------------------------------------
//               tratamiento INPUTs

    $("input")
        .focusin(function(){
            $(this).removeClass("borderRed");
            if($(this).val() == $(this).attr('alt')){
                $(this).val("");
            }
        })
        .focusout(function(){
            if($(this).val() == "")
                $(this).val($(this).attr('alt'));
        })
        .each(function(){
            $(this).val($(this).attr('alt'))
                .hide();
        });


// ------------------------------------------------------------------------------------------------
//      FIN ON BODY LOAD
});

// Close open dropdown slider by clicking elsewhwere on page
$(document).bind('click', function (e) {
    if (e.target.id != $('.dropdown').attr('class')) {
        $('.dropdown-slider').slideUp();
        $('span.toggle').removeClass('active');
    }
});

var ejecutorFlag = false;

//-----------------------------------------------------------------------
//                     Funciones


function dv(T){
    var M=0,S=1;
    for(;T;T=Math.floor(T/10))
        S=(S+T%10*(9-M++%6))%11;
    return S?S-1:'k';
}
function valida_rut(str){
    str = str.replace(".","");
    str = str.replace(" ","");
    var rut = str.split("-");
    if(rut[1] = dv(rut[0]))
        return true;
    else
        return false;
}


// -----------------------------------------------------------------------
//    Funciones de campos

function activaCampos(campos, ejecutorName){
    if(ejecutorFlag == ""){
        campos = campos + "";
        campos = campos.split(",");

        for (i=0; i < campos.length; i++){
                $("" + campos[i]).addClass("borderRed")
                    .fadeIn();
        }

        $("#divEjecutar").fadeIn();
        $("#b_cancelar").click(function(){
           escondeCampos(campos);
        });
            setEjecutor(campos, ejecutorName);
            return true;
    }else{
        alert("Finalice la acción anterior : " + $(".label", "#" + ejecutorFlag).html());
        return false
    }
}

function escondeCampos(campos){
    campos = campos + "";
    campos = campos.split(",");

    for (i=0; i < campos.length; i++){
            $("" + campos[i]).fadeOut()
                .val($("" + campos[i]).attr('alt'));
    }
    $("#divEjecutar").fadeOut();
    ejecutorFlag = "";
    $("#b_ejecutor").unbind('click');
    return true;
}

function validaCampos(campos){
    var camposRequeridos;
    var camposFallados = "";

    campos = campos + "";
    camposRequeridos = campos.split(",");

    for (i=0; i < camposRequeridos.length; i++){
        if ($("" + camposRequeridos[i]).val() == $("" + camposRequeridos[i]).attr('alt')){
            camposFallados +=  $("" + camposRequeridos[i]).attr('alt') + ", ";
            $("" + camposRequeridos[i]).addClass("borderRed")
                .fadeIn();
        }
    }

    if(camposFallados != ""){
        alert("Por favor, rellene los campos requeridos : " + camposFallados);
        return false;
    }else{
        return true;
    }

}


// ------------------------------------------------------------------------------
//         Ejecutor

function setEjecutor(campos,ejecutorName){
    var URL;
    var params;
    ejecutorFlag = ejecutorName;  //  impide que se inicie otra opcion

    $("#b_ejecutor").click(function(){   // setea la operación a realizar por el boton Ejecutar

        if(ejecutorName == "b_creaAlumno"){
            URL = "../ematadmin/creaunalumno?";
            params =  {
                creaunalumnop1 : $("#inputLista").val(),
                creaunalumnop2 : $("#inputRut").val(),
                creaunalumnop3 : $("#inputNombre").val(),
                creaunalumnop4 : $("#inputColegio").val(),
                creaunalumnop5 : $("#inputRutTutor").val(),
            };
        }else if(ejecutorName == "b_verAlumno"){
            URL = "../ematcons/verunrut?";
            params = {verunrutp1 : $("#inputRut").val()};

        }else if(ejecutorName == "b_crearTutor"){
            URL = "../ematadmin/creauntutor?";
            params = {
                creauntutorp1 : $("#inputColegio").val(),
                creauntutorp2 : $("#inputRutTutor").val(),
                creauntutorp3 : $("#inputNombreTutor").val(),
                creauntutorp4 : $("#inputMail").val(),
            };
        }else if(ejecutorName == "b_verTutor"){
            URL = "../ematadmin/vertutor?";
            params = {param1 : $("#inputRutTutor").val()};

        }else if(ejecutorName == "b_crearColegio"){
            URL = "../ematadmin/creauncolegio?";
            params = {
                creauncolegiop1 : $("#inputCodigo").val(),
                creauncolegiop2 : $("#inputNombreColegio").val(),
            }
        }else if(ejecutorName == "b_verSesionAlumno"){
            URL = "../ematadmin/verificasession?";
            params = {verificasessionp1 : $("#inputRut").val()};
        }else if(ejecutorName == "b_verSesionTutor"){
            URL = "../ematadmin/verificasesiontutor?";
            params = {
                verificasesiontutorp1 : $("#inputRut").val(),
                verificasesiontutorp2 : $("#inputLista").val(),
                verificasesiontutorp3 : $("#inputCodigo").val()
            };
        }else if(ejecutorName == "b_actividadesCurso"){ne0l0gik

            URL = "../ematcons/veractivcurso?";
            params = {
                veractivcursop1 : $("#inputLista").val(),
                veractivcursop2 : $("#inputCodigo").val()
            };
        }


        if($("#inputRut").val() != $("#inputRut").attr('alt')){   //  setea el rut como ultimo rut consultado
            $("#divUltimoRut").html($("#inputRut").val());
        }

        if(validaCampos(campos)){
           $.post(URL,params)
               .done(function(data){
                    $("#divResultado").html(data)
                        .focus()
                        .find("table").addClass("tableBlue");
               escondeCampos(campos);
           });
        }
    });

}
//-----------------------------------------------------------------------


