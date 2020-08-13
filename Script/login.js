$(document).ready(function () {
    $('.tab').on('click', function() {
        $('.tab').removeClass('is-active');
        $(this).addClass('is-active');

        $('form').removeClass('is-active');
        $('#' + $(this).attr('name') + 'Form').addClass('is-active');

        $('#selectedMode').val($(this).attr('name'));
    });

    if ($('#selectedMode').val() === "signup") {
        $('.tab').removeClass('is-active');
        $('.signupLabel').addClass('is-active');

        $('form').removeClass('is-active');
        $('#signupForm').addClass('is-active');
    }
});

function loginUser() {
    if ($('#loginEmail').val() && $('#loginPassword').val()) {
        $('#loginForm').submit();
    }
    else {
        console.log("失敗");
    }
}

function registUser() {
    if ($('#registUserName').val() && $('#registEmail').val() && $('#registPassword').val()) {
        $('#signupForm').submit();
    }
    else {
        console.log("失敗");
    }
}