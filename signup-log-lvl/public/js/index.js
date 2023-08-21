$('#register-form').submit(function(event) {
    event.preventDefault();
    console.log("I am not submitting");
    var formData = $('form').serialize();

    $.ajax({
        type: 'POST',
        url: './register',
        data: formData,
        success:function(response){
            const json_response=JSON.parse(response);
            console.log(json_response);

            $('.validate').text("");
            
            if(json_response.success==true){
                $('.dbValidation').text("Account created successfully!");
                $('#form-submit').prop('disabled', true);
                $('#form-submit').text("Please wait...");

                setTimeout(function() {
                    window.location.href = "login";
                }, 2000);

            }


            else{
                // console.log("Performing validations")

                const validObject=json_response["validations"]
                for(const key in validObject)
                    $(`.${key}`).text(validObject[key]);

            }
         
        }
    })


})


$('#login-form').submit(function(event) {
    event.preventDefault();
    // console.log("I am not submitting this form");

    var formData = $('form').serialize();

    $.ajax({
        type: 'POST',
        url: './login',
        data: formData,
        success:function(response){    
            // console.log(typeof(response))
            const json_response=JSON.parse(response);
            // console.log(json_response)
            $('.validate').text("");

            if(json_response.success==true)
                window.location.href="dashboard";
            else{
                const validObject=json_response["validations"]
                for(const key in validObject)
                    $(`.${key}`).text(validObject[key]);
            }
                  
            
        }
    })


})

