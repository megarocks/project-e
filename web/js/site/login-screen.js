jQuery(function ($) {
    $(document).on('click', '.login-container a[data-target]', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        console.log(target);
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
    });

    $(document).ready(setVisibleForm());
});

function setVisibleForm() {
    var activeForm = $('#visible-form').val();
    $('.widget-box.visible').removeClass('visible');
    $('#' + activeForm + '-box').addClass('visible');
    console.log(activeForm);
}
