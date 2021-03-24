$('document').ready(function(){

     $('#form_email').on('blur', function(){
        var email = $('#form_email').val();
        if (email == '') {
            email_state = false;
            return;
        }
        $.ajax({
         url: 'validate_user_email.php',
         type: 'post',
         data: {
             'email_check' : 1,
             'email' : email,
         },
         success: function(response){
             if (response) {
             alert('The email address already exists.');
             $('#form_email').val('');
             }
         }
        });
    });

});