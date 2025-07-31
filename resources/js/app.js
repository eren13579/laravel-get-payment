import "./bootstrap";

import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

import select2 from 'select2';
select2();

document.addEventListener('DOMContentLoaded', function() {
    $(".select2").select2({
        minimumResultsForSearch: 5,
        theme: 'default',
    });

    const currencyMap =
    window.appData && window.appData.currencyMap
    ? window.appData.currencyMap
    : {};

    const amountInput = $('#input-amount');
    const sendButton = $('#send-button');
    const currencyInput = $('#currency-input').val();
    const currencyInputText = currencyInput.text();
    const ButtonText = sendButton.text();

    amountInput.on('input', function() {
        let value = $(this).val();

        const origisnalButtonText = ButtonText;

        value = value.replace(/[^0-9.]/g, '');
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        $(this).val(value);

        if(currencyInputText === 'choose') {
            currencyInputText = ''
        } 

        if(value) {
            sendButton.text(`${origisnalButtonText} ${value}${currencyInputText}`);
        } else {
            sendButton.text(ButtonText);
        }
    })
    
    $('#input-amount', '#input-number').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, '');

        const parts = value.split('.');

        if(parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        $(this).val(value)
    });

    $("#country-select").on("change", function () {
        const selectdCountryId = $(this).val();

        if(!selectdCountryId) {
            $('#indicatif-input').val('');
            $('#currency-input').val('');
            $('#currency-input').trigger('change');
            return;
        }

        axios.get(`/get-country-data/${selectdCountryId}`).then(response => {
            const { indicatif, currency_id } = response.data;
            const deviseCode = currencyMap[currency_id] || '';

            $('#indicatif-input').val(indicatif);
            $('#currency-input').val(currency_id);
            $('#currency-input').trigger('change');
        }).catch(error => {
            console.error('Erreur lors de la récupération des données du pays:', error);
            $('#indicatif-input').val('');
            $('#currency-input').val('');
            $('#currency-input').trigger('change');
        });
    });

});

import Alpine from "alpinejs";
import axios from "axios";
window.Alpine = Alpine;
Alpine.start();
