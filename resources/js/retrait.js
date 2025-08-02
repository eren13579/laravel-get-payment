export function Retrait() {
    document.addEventListener("DOMContentLoaded", function () {
        const transferMethodSelect = document.getElementById("input-method");
        const currencyInput = document.getElementById("currency-method");
        const amountMethode = $("#retrait-amount");
        const numberMethode = $("#retrait-number");
        let sendButtonRetrait = $("#retrait-button");
        const ButtonTextRetrait = sendButtonRetrait.text(); 
        const form = $("#retrait-form");
        const currencyError = $("#currency-retrait-error");
        const amountError = $("#amount-retrait-error");
        const numberError = $("#number-retrait-error");
        const methodError = $("#method-error");


        form.on("submit", function (event) {
            // Cache tous les messages d'erreur au début
            amountError.hide();
            numberError.hide();
            currencyError.hide();
            methodError.hide();

            let isValid = true;

            // Validation du champ de montant
            if (!amountMethode[0].checkValidity()) {
                amountError.show();
                isValid = false;
            }

            if (!transferMethodSelect[0].checkValidity()) {
                methodError.show();
                isValid = false;
            }

            // Validation du champ du numéro
            if (!numberMethode[0].checkValidity()) {
                numberError.show();
                isValid = false;
            }

            // Validation du champ de devise
            if (!currencyInput[0].checkValidity()) {
                currencyError.show();
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        if (transferMethodSelect && currencyInput) {
            transferMethodSelect.addEventListener("change", function () {
                const selectedOption = this.options[this.selectedIndex];
                const selectedCurrency =
                    selectedOption.getAttribute("data-currency");
                currencyInput.value = selectedCurrency;
            });
        }

        amountMethode.on("input", function () {
            let value = $(this).val();

            value = value.replace(/[^0-9.]/g, "");
            const parts = value.split(".");
            if (parts.length > 2) {
                value = parts[0] + "." + parts.slice(1).join("");
            }
            $(this).val(value);
        });

        numberMethode.on("input", function () {
            let value = $(this).val();
            value = value.replace(/[^0-9]/g, "");
            $(this).val(value);
        });

        form.on('submit', function (event) {
            event.preventDefault();
            const formData = $(this).serialize();

            sendButtonRetrait = $(this).find('button[type="submit"]');
            sendButtonRetrait.prop("disabled", true);
            sendButtonRetrait.text("In progress...");

            $.ajax({
                method: "POST",
                url: "/retrait",
                data: formData,
                hearders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    notyf.success(response.message);
                    form.trigger('reset');
                },
                error: function (xhr, status, error) {
                    const response = xhr.responseJSON;
                    notyf.error(response.message);
                },
                complete: function() {
                    sendButton.prop("disabled", false);
                    sendButton.text(ButtonTextRetrait);
                }
            });
        });
    });
}
