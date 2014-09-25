var initScreen = function (user) {

    var values = getValues();

    setValuesOnPage(values);

    handlePeriodsChange(values);

    handleFromChange(values);
};

function getValues() {
    return {
        payerType: $('input[name="Payment[from]"]:checked', '#payment-create-form').val(),
        periods: $('#payment-periods').val(),
        dmp: $('input[name=dmp]').val(),
        cmp: $('input[name=cmp]').val(),
        access_token: $('input[name=access_token]').val()
    };
}

function setValuesOnPage(values) {
    var sumToPay = 0;
    //get value for unlock date
    var unlockDate = $('option:selected', '#payment-periods').attr('date');

    if (values.payerType == 'enduser') {
        sumToPay = (values.cmp * values.periods).toFixed(2);
        $('#next-lock-date-text').show();
    }
    if (values.payerType == 'distributor') {
        sumToPay = (values.dmp * values.periods).toFixed(2);
        $('#next-lock-date-text').hide();
    }

    if (values.periods == 0) {
        $('.add-payment-btn').prop('disabled', true);
        $('#payment-details').hide();
    } else {
        $('.add-payment-btn').prop('disabled', false);
        $('#payment-details').show();
    }

    $('#billed-sum-amount').text(sumToPay);
    $('#next-locking-date-value').text(unlockDate);
}

function handlePeriodsChange() {
    $('#payment-periods').on('change', function () {
        setValuesOnPage(getValues());
    });
}

function handleFromChange() {
    $('input[name="Payment[from]"]').on('change', function () {
        var values = getValues();
        $.get('/payment/periods-drop-down/?for=' + values.payerType + '&access_token=' + values.access_token, function (data) {
            $('#payment-periods').replaceWith(data);
            handlePeriodsChange();
            setValuesOnPage(getValues());
        });

    })
}