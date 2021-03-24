var AppJ = AppJ || {};

AppJ.onSelectTypeLesson = function (e) {
    var lessonTypeCode = e.value
			, lessonType = $(e).find('option[value="' + lessonTypeCode + '"]').data('lesson-type')
            , factor =  AppJ.config.lessonRateFactor[lessonType]			
            , rate =  AppJ.config.rate
            , calculatedRate = rate * factor;

    lessonType = e.querySelector("option[value='" + lessonTypeCode + "']").getAttribute('data-lesson-type');

    document.querySelector("#form_rate").value = calculatedRate;
    lessonType = parseInt(lessonType);
    _selected_lesson_type = lessonType;
    //in_array($_selected_lesson_type, array(1,2,3)))
    var _anArray = [1, 2, 3];
    if (_anArray.indexOf(_selected_lesson_type) >= 0) {// CASE 1: WRITEN SOLUTION/LESSON        
        $('#case1-id').css({"display": "initial"});
        $('#conditions').css({"display": "initial"});
    } else {
        $('#case1-id').css({"display": "none"});
        $('#conditions').css({"display": "none"});
    }

    if (lessonType === 1) {  // CASE 2: SCHEDULED LESSON scheduled-lesson-id 
        $('#case2-id').css({"display": "initial"});
    } else {
        $('#case2-id').css({"display": "none"});
    }
};

if(document.getElementById('form_requestlesson').value !='no'){


AppJ.eatTimer1 = new easytimer.Timer();

AppJ.eatTimer1.start({precision: 'seconds', countdown: true, startValues: {seconds: Math.max(1, AppJ.config.MAXWAITINGTIMEFORSTUDENT - AppJ.config.SECONDS_SINCE_REQUEST)}});
//var eatTimer1Message = 'There are no tutors available at this time. Please submit the assignment as a "Written solution" request type';

var eatTimer1Message = 'The selected Tutor could not attend your request, please try again or set a Scheduled lesson';

$('#eatTimer1 .values').html(AppJ.eatTimer1.getTimeValues().toString());
//$('#eatTimer1 .progress_bar').html(eatTimer1Message);
AppJ.eatTimer1.addEventListener('secondsUpdated', function (e) {
    $('#eatTimer1 .values').html(AppJ.eatTimer1.getTimeValues().toString());
	$('#eatTimer1 .progress_bar').html($('#eatTimer1 .progress_bar').html() + '.');
	// Cada segundo revisar si el tutor ha aceptado la lección instantánea
	// Si es el caso,  recargar la página para que se muestre la sección de ingreso a la lección.

	$.ajax({
		url: 'get_instant_lesson_accepted.php',
		type: 'post',
		data: {
			'usercode' : usercode,
		},
		success: function(response){
			if (response) {
				AppJ.eatTimer1.stop();
				reload();
			}
		}
	   });
});

AppJ.eatTimer1.addEventListener('targetAchieved', function (e) {
    $('#eatTimer1 .progress_bar').html(eatTimer1Message);
	alert(eatTimer1Message);
	AppJ.eatTimer1.stop();
	cancel();
});

}

// Función agregada para obtener el saldo de crédito disponible para el estudiante.
// Si el saldo es menor al requerido para el tutor seleccionado, abrir la sección de pago
// para comprar más crédito.

AppJ.getAvailableMinutes = function(e, balance){
	var usercode_tutor = "";
	var tariff_text = "";
	var indice = 0;
	var tariff_tutor_text = "";
	var tariff_tutor_float = 0.00;
	var available_minutes = 0;
	var mas_credito = false;
	
	
	// Obtenemos la tarifa del tutor seleccionado.
	usercode_tutor	= e.value;							// Obtener el código del tutor.
	tariff_text = e.options[e.selectedIndex].text;		// Obtener el nombre y tarifa del tutor.
	indice = tariff_text.indexOf("$")+1;
	tariff_tutor_text = tariff_text.slice(indice, tariff_text.length-5); // Obtener sólo la tarif del tutor.
	tariff_tutor_float = parseFloat(Number(tariff_tutor_text));			 //  Convertir en valor numérico.
	document.getElementById("form_tarifftutor").value = tariff_tutor_text;  // Guardamos la tarifa del tutor.
	document.getElementById("form_rate").value = tariff_tutor_text;  // Guardamos la tarifa del tutor.
	
	// Si el saldo de crédito disponible no es suficiente se debe mostrar la sección de payment.
	if(balance < tariff_tutor_float){
		alert("Insuficient Available credit. Please add more credit.");
		document.getElementById("form_availableminutes").value = parseInt(balance / tariff_tutor_float * 60);
		mas_credito = true;
	} else {
		available_minutes = parseInt(balance / tariff_tutor_float * 60);
		document.getElementById("form_availableminutes").value = available_minutes;
		mas_credito = false;
	}
	
	document.getElementById("form_requestlesson").value='no';
	
	if (mas_credito){
		$('#payment_section').css({"display": "block"});
		document.getElementById("requestbutton").disabled = true;
	} else {
		$('#payment_section').css({"display": "none"});
		document.getElementById("requestbutton").disabled = false;
	}
}
















