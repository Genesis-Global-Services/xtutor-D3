var AppJ = AppJ || {};

AppJ.onSelectTypeLesson = function (e) {
    var lessonTypeCode = e.value
            , lessonType = $(e).find('option[value="' + lessonTypeCode + '"]').data('lesson-type')
            , rate = AppJ.config.rate
            , factor = AppJ.config.lessonRateFactor[lessonType]
            , calculatedRate = rate * factor;

    lessonType = e.querySelector("option[value='" + lessonTypeCode + "']").getAttribute('data-lesson-type');

    document.querySelector("#form_rate").value = calculatedRate;
   
};


AppJ.eatTimer1 = new easytimer.Timer();


AppJ.eatTimer1.start({precision: 'seconds',countdown:true, startValues: {seconds: Math.max(1,AppJ.config.MAXWAITINGTIMEFORSTUDENT-AppJ.config.SECONDS_SINCE_REQUEST) }});
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