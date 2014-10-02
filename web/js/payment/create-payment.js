var initScreen = function (user) {

    var values = getValues();

    setValuesOnPage(values);

    handlePeriodsChange(values);

    handleFromChange(values);

    $('.add-payment-btn').bind('click', function (event) {
        event.preventDefault();

        var values = getValues();

        var paymentDetails = "<h3>Confirm Payment Details:</h3>";

        paymentDetails += "<strong>System SN:</strong>&nbsp;" + values.system_sn + "<br/>"
        + "<strong>Purchase Order #:</strong>&nbsp;" + values.po_num + "<br/>";

        if (values.payerType == 'enduser') {
            var sumToPay = (values.cmp * values.periods).toFixed(2);

            paymentDetails += "<strong>End-User:</strong>&nbsp;" + values.end_user_title + "<br/>"
            + "<strong>Amount:</strong>&nbsp;" + sumToPay + "&nbsp;" + values.currency_code + "<br/>";
        }

        if (values.payerType == 'distributor') {
            var sumToPay = (values.dmp * values.periods).toFixed(2);

            paymentDetails += "<strong>Distributor:</strong>&nbsp;" + values.distributor_title + "<br/>"
            + "<strong>Amount:</strong>&nbsp;" + sumToPay + "&nbsp;" + values.currency_code + "<br/>";
        }

        bootbox.confirm(paymentDetails, function (result) {
            if (result) {
                $('#payment-create-form').submit();
                console.log('submit');
            } else {
                console.log('not submit');
            }
        })

    });
};

function getValues() {
    return {
        payerType: $('input[name="Payment[from]"]:checked', '#payment-create-form').val() || $('#payment-from').val(),
        periods: $('#payment-periods').val(),
        dmp: $('input[name=dmp]').val(),
        cmp: $('input[name=cmp]').val(),
        access_token: $('input[name=access_token]').val(),
        system_sn: $('#system_sn').val(),
        po_num: $('#po_num').val(),
        currency_code: $('#currency_code').val(),
        end_user_title: $('#end_user_title').val(),
        distributor_title: $('#distributor_title').val()
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
        $('.add-payment-btn').addClass('disabled');
        $('#payment-details').hide();
    } else {
        $('.add-payment-btn').removeClass('disabled');
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