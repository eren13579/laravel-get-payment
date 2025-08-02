

export function Depots() {
    document.addEventListener("DOMContentLoaded", function () {
        $(".select2").select2({
            minimumResultsForSearch: 5,
            theme: "default",
        });

        const amountInput = $("#input-amount");
        const currencyInput = $("#currency-input");
        const numberInput = $("#input-number");
        const countryInput = $("#country-select");
        let sendButton = $("#send-button");
        const ButtonText = sendButton.text();
        const form = $("#depot-form");
        const amountError = $("#amount-error");
        const numberError = $("#number-error");
        const currencyError = $("#currency-error");
        const countryError = $("#country-error");

        form.on("submit", function (event) {
            // Cache tous les messages d'erreur au début
            amountError.hide();
            numberError.hide();
            currencyError.hide();
            countryError.hide();

            let isValid = true;

            // Validation du champ de montant
            if (!amountInput[0].checkValidity()) {
                amountError.show();
                isValid = false;
            }

            if (!countryInput[0].checkValidity()) {
                countryError.show();
                isValid = false;
            }

            // Validation du champ du numéro
            if (!numberInput[0].checkValidity()) {
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

        function updateSendButton() {
            const amountValue = amountInput.val();
            const currencyValue = currencyInput.val();
            const origisnalButtonText = ButtonText;

            if (amountValue && currencyValue) {
                sendButton.text(
                    `${origisnalButtonText}    ${amountValue}${currencyValue}`
                );
            } else if (amountValue || currencyValue) {
                sendButton.text(origisnalButtonText);
            } else {
                sendButton.text(origisnalButtonText);
            }
        }

        amountInput.on("input", function () {
            let value = $(this).val();

            value = value.replace(/[^0-9.]/g, "");
            const parts = value.split(".");
            if (parts.length > 2) {
                value = parts[0] + "." + parts.slice(1).join("");
            }
            $(this).val(value);

            updateSendButton();
        });

        currencyInput.on("change", function () {
            updateSendButton();
        });

        $("#input-number").on("input", function () {
            let value = $(this).val();
            value = value.replace(/[^0-9]/g, "");
            $(this).val(value);
        });

        form.on("submit", function (event) {
            event.preventDefault();
            const formData = $(this).serialize();

            sendButton = $(this).find('button[type="submit"]');
            sendButton.prop("disabled", true);
            sendButton.text("In progress...");

            $.ajax({
                method: "POST",
                url: depotRoute,
                data: formData,
                success: function (response) {
                    if (response.checkout_url) {
                        window.location.href = response.checkout_url;
                    } else {
                        notyf.error("Réponse du serveur invalide.");
                    }
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    if (response && response.errors) {
                        for (const key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                notyf.error(response.errors[key][0]);
                            }
                        }
                    } else if (response && response.message) {
                        notyf.error(response.message);
                    } else {
                        notyf.error(
                            "Une erreur inattendue s'est produite lors de la soumission."
                        );
                    }
                },
                complete: function () {
                    sendButton.prop("disabled", false);
                    sendButton.text(ButtonText);
                },
            });
        });
    });
}
