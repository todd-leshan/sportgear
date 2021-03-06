//live time
function liveClock()
{
    var currentTime = new Date();

    var hour   = currentTime.getHours();
    var minute = currentTime.getMinutes();
    var second = currentTime.getSeconds();

    var day    = currentTime.getDate();
    var month  = currentTime.getMonth();
    var year   = currentTime.getFullYear();

    var montharray = new Array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");

    minute = (minute<10 ? "0":"") + minute;
    second = (second<10 ? "0":"") + second;

    var now = day+" "+montharray[month]+", "+year+" | "+hour + ":" + minute + ":" + second;

    document.getElementById("clock").innerHTML = now;
}    

window.setInterval('liveClock()', 1000);

//product image gallery customize
$(document).ready(function(){   

    $('#product-display').slick({
        autoplay:true,
        dots: true,
        speed:1000
    });

});

//contact form validation
function valid(field)
{
    field.removeClass("invalid").addClass("valid");
    field.siblings(".error_show").removeClass("error_show").addClass("error");
}

function invalid(field)
{
    field.removeClass("valid").addClass("invalid");
    field.siblings(".error").removeClass("error").addClass("error_show");
}

function displayError(field, message)
{
    field.siblings(".error_show").text(message);
}

function validateField(field)
{
    switch (field.attr("id")){
        case "contact_firstname":

            if(field.val().length < 3)
            {
                invalid(field);
                displayError(field, "Firstname must be at least 3 characters!");
                return false;
            }
            else
            {
                valid(field);
            }

            var regex = /^[a-zA-Z0-9_-]*$/;
            if(!regex.test(field.val()))
            {
                invalid(field);
                displayError(field, "Firstname can only contain \"a-zA-Z0-9_-\"!");
                return false;
            }
            else
            {
                valid(field);
            }
        break;

        case "contact_lastname":

            if(field.val().length < 3)
            {
                invalid(field);
                displayError(field, "Lastname must be at least 3 characters!");
                return false;
            }
            else
            {
                valid(field);
            }

            var regex = /^[a-zA-Z0-9_-]*$/;
            if(!regex.test(field.val()))
            {
                invalid(field);
                displayError(field, "Lastname can only contain \"a-zA-Z0-9_-\"!");
                return false;
            }
            else
            {
                valid(field);
            }
        break;

        case "contact_phone":
            var is_filled = field.val();
            if(is_filled)
            {
                var mobile   = /^04[0-9]{2}[ -]?[0-9]{3}[ -]?[0-9]{3}$/;
                var landline = /^[3-9]{1}[0-9]{3}[ -]?[0-9]{4}$/;
                var landline1 = /^0[2,3,7,8]{1}[ -]?[3-9]{1}[0-9]{3}[ -]?[0-9]{4}$/;
                var is_mobile   =mobile.test(field.val());
                var is_landline =landline.test(field.val());
                var is_landline1=landline1.test(field.val());
                
                if(is_mobile || is_landline || is_landline1)
                {
                    valid(field);
                }
                else
                {
                    invalid(field);
                    return false;
                }
            }
            else
            {
                //valid(field);
                invalid(field);
                return false;
            }
        break;

        case "contact_message":
            //console.log(message);
            if(field.val().length < 10)
            {
                invalid(field);
                displayError(field, "Message must be at least 10 characters!");
                return false;
            }
            else
            {
                valid(field);
            }
    }

    return true;
}

function validateUsername(field)
{
    if(field.val().length < 3)
    {
        invalid(field);
        displayError(field, "Username must be at least 3 characters!");
        return false;
    }
    else
    {
        valid(field);
    }

    var regex = /^[a-zA-Z0-9_-]*$/;
    if(!regex.test(field.val()))
    {
        invalid(field);
        displayError(field, "Username can only contain \"a-zA-Z0-9_-\"!");
        return false;
    }
    else
    {
        valid(field);
    }
}

function validateEmail(field)
{
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var is_email=re.test(field.val());
    if(is_email)
    {
        valid(field);
    }
    else
    {
        invalid(field);
        return false;
    }
}

function validatePassword(field)
{
    if(field.val().length < 8)
    {
        invalid(field);
        displayError(field, "Password must be at least 8 characters!");
        return false;
    }
    else
    {
        valid(field);
    }

    var regex = /^[a-zA-Z0-9_-]*$/;
    if(!regex.test(field.val()))
    {
        invalid(field);
        displayError(field, "Password can only contain \"a-zA-Z0-9_-\"!");
        return false;
    }
    else
    {
        valid(field);
    }
}

//if two fields are matched, return true
function isMatch(field1, field2)
{
    if(field1.val() == field2.val())
    {   
        valid(field2);
        return true;
    }
    invalid(field2);
    displayError(field2, "Passwords must be the same!");
    return false;
}

function isDifferent(field1, field2)
{
    if(field1.val() != field2.val())
    {   
        valid(field2);
        return true;
    }
    invalid(field2);
    displayError(field2, "New password can not be the same as the old one");
    return false;
}
//when changing password, the old password can not be the same as the new one

$(document).ready(function(){

    //check firstname
    $('#contact_firstname, #contact_lastname, #contact_phone, #contact_email').on('keyup', function() 
    {
        validateField($(this));

    });

    $('#contact_email').on('keyup', function() 
    {
        validateEmail($(this));

    });

    $('#contact_message').keyup(function(event) 
    {
        validateField($(this)); 
    });

    //<!-- After Form Submitted Validation-->
    $("#submitButton").click(function(event){
    //$("#contact").submit(function(event){
    var form_data=$("#contact").serializeArray();
    var error_free=true;
    for (var input in form_data)
    {
        var element=$("#contact_"+form_data[input]['name']);
        var valid=element.hasClass("valid");
        var error_element=$("span", element.parent());
        if (!valid)
        {
            error_element.removeClass("error").addClass("error_show"); 
            error_free=false;
        }
        else
        {
            error_element.removeClass("error_show").addClass("error");
        }
    }
    if (!error_free){
        event.preventDefault();
    }
    else{
        alert('Thanks for leaving a message!');
    }
    });
});

//sign in form validation
$(document).ready(function(){

    //check firstname
    $('#signin-username').on('keyup', function() 
    {
        validateUsername($(this));

    });

    $('#signin-password').on('keyup', function()
    {
        validatePassword($(this));
    });

    //<!-- After Form Submitted Validation-->
    $("#signinButton").click(function(event){
    //$("#contact").submit(function(event){
    var form_data=$("#signin").serializeArray();
    var error_free=true;
    for (var input in form_data)
    {
        var element=$("#signin-"+form_data[input]['name']);
        var valid=element.hasClass("valid");
        var error_element=$("span", element.parent());
        if (!valid)
        {
            error_element.removeClass("error").addClass("error_show"); 
            error_free=false;
        }
        else
        {
            error_element.removeClass("error_show").addClass("error");
        }
    }
    if (!error_free){
        event.preventDefault();
    }
    else{
        return true;
    }
    });
});

//sign up form validation
$(document).ready(function(){

    //check firstname
    $('#signup-username').on('keyup', function() 
    {
        validateUsername($(this));

    });

    $('#signup-password1').on('keyup', function()
    {
        validatePassword($(this));
    });

    $('#signup-password2').on('focusout', function()
    {
        //pass1 = document.getElementById('signup-password1');
        //pass2 = document.getElementById('signup-password2');
        pass1 = $('#signup-password1');
        pass2 = $('#signup-password2');
        isMatch(pass1, pass2);
    });

    $('#signup-email').on('keyup', function()
    {
        validateEmail($(this));
    });

    //<!-- After Form Submitted Validation-->
    $("#signupButton").click(function(event){
    //$("#contact").submit(function(event){
    var form_data=$("#signin").serializeArray();
    var error_free=true;
    for (var input in form_data)
    {
        var element=$("#signup-"+form_data[input]['name']);
        var valid=element.hasClass("valid");
        var error_element=$("span", element.parent());
        if (!valid)
        {
            error_element.removeClass("error").addClass("error_show"); 
            error_free=false;
        }
        else
        {
            error_element.removeClass("error_show").addClass("error");
        }
    }
    if (!error_free){
        event.preventDefault();
    }
    else{
        return true;
    }
    });
});

/****************************************************************/
//staff change password form validation
$(document).ready(function()
{
    $('#change-password1').on('keyup', function()
    {
        validatePassword($(this));
    });

    $('#change-password2').on('keyup', function()
    {
        validatePassword($(this));
    });

    $('#change-password2').on('focusout', function()
    {
        pass1 = $('#change-password1');
        pass2 = $('#change-password2');
        isDifferent(pass1, pass2);
    });

    $('#change-password3').on('focusout', function()
    {
        pass2 = $('#change-password2');
        pass3 = $('#change-password3');
        isMatch(pass2, pass3);
    });

    //<!-- After Form Submitted Validation-->
    $("#changePasswordButton").click(function(event){
    //$("#contact").submit(function(event){
    var form_data=$("#signin").serializeArray();
    var error_free=true;
    for (var input in form_data)
    {
        var element=$("#"+form_data[input]['name']);
        var valid=element.hasClass("valid");
        var error_element=$("span", element.parent());
        if (!valid)
        {
            error_element.removeClass("error").addClass("error_show"); 
            error_free=false;
        }
        else
        {
            error_element.removeClass("error_show").addClass("error");
        }
    }
    if (!error_free){
        event.preventDefault();
    }
    else{
        return true;
    }
    });
});
