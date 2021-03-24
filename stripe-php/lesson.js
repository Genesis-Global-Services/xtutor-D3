var AppJ = AppJ || {};

AppJ.onSelectTypeLesson = function (e) {
    var lessonTypeCode = e.value
            , lessonType = $(e).find('option[value="' + lessonTypeCode + '"]').data('lesson-type')
            , rate = AppJ.config.rate
            , factor = AppJ.config.lessonRateFactor[lessonType]
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

    if (lessonType === 2) {  // CASE 2: SCHEDULED LESSON scheduled-lesson-id 
        $('#case2-id').css({"display": "initial"});
    } else {
        $('#case2-id').css({"display": "none"});
    }
};


AppJ.eatTimer1 = new easytimer.Timer();


AppJ.eatTimer1.start({precision: 'seconds', countdown: true, startValues: {seconds: Math.max(1, AppJ.config.MAXWAITINGTIMEFORSTUDENT - AppJ.config.SECONDS_SINCE_REQUEST)}});
var eatTimer1Message = 'There are no tutors available at this time. Please submit the assignment as a "Written solution" request type';
$('#eatTimer1 .values').html(AppJ.eatTimer1.getTimeValues().toString());
//$('#eatTimer1 .progress_bar').html(eatTimer1Message);
AppJ.eatTimer1.addEventListener('secondsUpdated', function (e) {
    $('#eatTimer1 .values').html(AppJ.eatTimer1.getTimeValues().toString());
    $('#eatTimer1 .progress_bar').html($('#eatTimer1 .progress_bar').html() + '.');
});
AppJ.eatTimer1.addEventListener('targetAchieved', function (e) {
    $('#eatTimer1 .progress_bar').html(eatTimer1Message);
});

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
	document.getElementById('form_tariffturor').value = tariff_tutor_text;  // Guardamos la tarifa del tutor.
	
	// Si el saldo de crédito disponible no es suficiente se debe mostrar la sección de payment.
	if(balance < tariff_tutor_float){
		alert("Saldo insuficiente.  Compre más credito.");
		document.getElementById("form_availableminutes").value = balance;
		mas_credito = true;
	} else {
		available_minutes = parseInt(balance / tariff_tutor_float * 60);
		document.getElementById("form_availableminutes").value = available_minutes;
		mas_credito = false;
	}
	
	if (mas_credito){
		$('#payment_section').css({"display": "block"});
	} else {
		$('#payment_section').css({"display": "none"});
	}
}
















