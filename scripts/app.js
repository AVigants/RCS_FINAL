$(function () {
    //----------------------------dom queries-----------------------------------------------------
    const regFormInputs = $('#registerForm input');
    const passField = document.querySelector('#registerForm > div:nth-child(6) > input');
    const loginEmail = document.querySelector('#loginForm > div:nth-child(3) > input');
    const loginPass = document.querySelector('#loginForm > div:nth-child(4) > input');
    const forgotPass = $('#loginForm > div.clearfix > a');
    const passResetEmailField = document.querySelector('#passResetEmail');
    const registeredUserSpan = document.getElementById('registeredUserSpan');
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

    //--------------------reg_submit event-------------------
    // $('#registerForm').submit(e => {
    //     if (reg_values.reg_fname && reg_values.reg_username && reg_values.reg_email && reg_values.reg_pass && reg_values.reg_cpass) {
    //         renderThankYou(reg_values.reg_fname);
    //     }
    // });
    // thank you for registering---------------------------------
    function renderThankYou(fname) {
        $('#outerDiv').fadeIn();
        $('#innerDiv span').text(fname)
        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                $('#outerDiv').fadeOut(100);
            }
        });

        $('#close').click(e => {
            $('#outerDiv').fadeOut(100);
        });
        //rainbow colored text
        $('innerDiv span').text(userObj.fname);
        for (let i = 0; i < 360; i++) {
            setTimeout(() => {
                registeredUserSpan.style.color = `hsl(${i}, 100%, 50%)`;
            }, i * 10);
        };
        setTimeout(() => {
            $('#outerDiv').fadeOut(100);
        }, 3600);
        //go back to login form
        $('#registerFormWrapper').fadeOut(200);
        setTimeout(() => {
            $('#loginFormWrapper').fadeIn(200);
        }, 200);
    }//end of renderThankYou
})//end of JQuery block

//-------------------------COMMENTS-------------------------------------
// todo: dom queries is a mess
//todo: thank you for registering - once we get the confirmation form php. also - store the script in local storage? and fire it after some time...
// todo:register form submit event and thank you rennder is buggy
//bugfix: thankyou render outer div doesnt fit the whole screen - you can scroll down.