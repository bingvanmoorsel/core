$(document).ready(function(){

    $('.victory-form__datepicker').datepicker({

    });

    $('.victory-form__priceformat').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });

    console.log('victory!');
});