$(document).ready(function () {
    $('.tab').on('click', function() {
        $('.tab').removeClass('is-active');
        $(this).addClass('is-active');

        $('form').removeClass('is-active');
        $('#' + $(this).attr('name') + 'Form').addClass('is-active');
    });
});

function registUser() {
    if ($('#userName').val() && $('#email').val() && $('#password').val()) {
        $('#registForm').submit();
    }
    else {
        console.log("失敗");
    }
}