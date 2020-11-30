$(function () {
    //-------------------variable declaration to prevent errors-----------------------------------------------
    const patterns = {
        reg_fname: /^[a-zA-Z]{2,25}$/,
        reg_username: /^[a-zA-Z]{2,25}$/,
        reg_email: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/,
        reg_pass: /^[\w@-]{8,25}$/,
        reg_cpass: /^[\w@-]{8,25}$/,
    };
    let reg_values = {
    reg_fname: '',
    reg_username: '',
    reg_email: '',
    reg_pass: '',
    reg_cpass: ''
    };
    //--------------------------------show/hide 'login/register' forms with JQuery -----------------------
    $('#registerHref').click(e => {
        $('#loginFormWrapper').fadeOut(200);
        setTimeout(() => {
            $('#registerFormWrapper').fadeIn(200);
        }, 200);
    });
    $('#loginHref').click(e => {
        $('#registerFormWrapper').fadeOut(200);
        setTimeout(() => {
            $('#loginFormWrapper').fadeIn(200);
        }, 200);
    });

    //---------------------------------show/hide 'forgot password' form with JQuery--------------------------------------------
    const forgotPass = $('#loginForm > div.clearfix > a');
    forgotPass.click(e => {
        $('#passResetForm').slideToggle();
    })
    //------------------------register form data validation on keyup event---------------------------------
    $('#registerForm > div > input').keyup(e => {
        validateOnKeyup(e.target.value.trim(), e.target);
    });
    function validateOnKeyup(data, field) {
        if (patterns[field.name].test(data)) {
            field.classList.add('valid')
            field.classList.remove('invalid');
            reg_values[field.name] = data;
        } else {
            field.classList.add('invalid');
            field.classList.remove('valid');
            reg_values[field.name] = '';
        }
    }
})
