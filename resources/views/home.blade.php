<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Get-payment</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /><!-- CDN -->
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-300">
    <main class="relative flex items-center justify-center pt-20 py-40">
        <section>
            <div class="mt-4">
                <div x-data="{ active: @js($name ?? 'depot') || @js($name ?? 'retrait') }" class="w-full p-4 bg-white rounded shadow">
                    <div class="flex border-t border-t-indigo-600 gap-0.5 mb-4">
                        <button @click="active = 'depot'"
                            :class="active === 'depot' ? 'border-t-2 border-t-indigo-600 font-bold' : 'text-gray-500'"
                            class="pb-2 transition-all w-62.5">
                            Dépot
                        </button>
                        <button @click="active = 'retrait'"
                            :class="active === 'retrait' ? 'border-t-2 border-t-indigo-600 font-bold' : 'text-gray-500'"
                            class="pb-2 transition-all w-70">
                            Retrait
                        </button>
                    </div>

                    <div>
                        <div x-show="active === 'depot'" x-transition.opacity x-transition.duration.300ms
                            class="p-4">
                            <div>
                                <div class="w-125 h-115" id="depot">
                                    <div class="mt-4 mx-4">
                                        <div class="text-center font-bold text-base">
                                            <h5>Veuillez Remplire les champs ci-dessous</h5>
                                        </div>
                                        <form method="" id="depot-form">
                                            @csrf

                                            <div class="mt-3 space-y-2 row-auto">
                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="country-select">Country</label>
                                                        <select name="country" id="country-select" required
                                                            value=""
                                                            class="mt-1 select2 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                            <option value="">Choose</option>
                                                            @foreach (config('countries') as $key => $country)
                                                                <option class="" value="{{ $key }}">
                                                                    {{ $country }}</option>
                                                            @endforeach
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <span id="country-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="currency-input">Enter your currency</label>
                                                        <select name="currency" id="currency-input" required
                                                            class="select2 not-first:mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                            <option value="">Choose</option>
                                                            @foreach (config('currencies.currency_list') as $currency => $key)
                                                                <option value="{{ $key }}">
                                                                    {{ $key }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="currency-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="input-number">Phone number</label>
                                                        <div class="flex gap-2">
                                                            <input type="text" value="" id="indicatif-input"
                                                                required name="code"
                                                                class="mt-1 w-15 rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                                placeholder="" readonly />
                                                            <input min="0" type="text" id="input-number"
                                                                name="number" required
                                                                class="mt-1 w-100 block rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                                placeholder="" />
                                                        </div>
                                                        <span id="number-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row">
                                                    <div class="block">
                                                        <label for="input-amount">Amounts</label>
                                                        <input min="0" type="text" id="input-amount"
                                                            name="amounts" required value=""
                                                            class="mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                            placeholder="" />
                                                        <span id="amount-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="block">
                                                    <div class="mt-2">
                                                        <div>
                                                            <div class="inline-flex items-center">
                                                                <input type="checkbox" name="verify" required
                                                                    value="1"
                                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:ring-offset-0"
                                                                    checked />
                                                                <span class="ml-2">Do you accept that you have
                                                                    provided the information !</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="px-5 py-6">
                                                    <button id="send-button" type="submit"
                                                        class="text-center text-white w-full border h-[47px] bg-green-500 rounded-[37px] hover:bg-green-700">
                                                        Send </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="active === 'retrait'" x-transition.opacity x-transition.duration.300ms
                            class="p-4">
                            <div>
                                <div class="w-125 h-115" id="retrait">
                                    <div class="mt-4 mx-4">
                                        <div class="text-center font-bold text-base">
                                            <h5>Veuillez Remplire les champs ci-dessous</h5>
                                        </div>

                                        <form method="POST" id="retrait-form" action="/retrait">
                                            @csrf

                                            <div class="mt-3 space-y-2 row-auto">
                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="input-method">Transfer method</label>
                                                        <select name="transfer_method" id="input-method" requiredvalue=""
                                                            class="mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                            <option value="">Choose</option>
                                                            @foreach (config('method') as $key => [$method, $devise])
                                                                <option class="" data-currency="{{ $devise }}"  value="{{ $key }}">
                                                                    {{ $method }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span id="method-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="currency-method">Currency</label>
                                                        <input type="text" id="currency-method" name="currency" required value=""
                                                            class="mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                            placeholder="" />
                                                        <span id="currency-retrait-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="d-flex flex-row">
                                                    <div class="block">
                                                        <label for="retrait-amount">Amounts</label>
                                                        <input min="0" type="text" id="retrait-amount" name="amounts" required value=""
                                                            class="mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                            placeholder="" />
                                                        <span id="amount-retrait-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="inputbox">
                                                    <div class="block">
                                                        <label for="retrait-number">Phone number</label>
                                                        <div class="flex gap-1">
                                                            <div class="rounded-md">
                                                                <select value="" id="retrait-indicatif" required name="code" placeholder=""
                                                                    class="mt-1 w-18 select2 block rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                                    @foreach (config('countries') as $key => $country)
                                                                        <option value="{{ $key }}">
                                                                            {{ $key }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <input min="0" type="text" id="retrait-number"
                                                                name="number" required
                                                                class="mt-1 w-98 block rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                                placeholder="" />
                                                        </div>
                                                        <span id="number-retrait-error" class="text-red-500 text-sm mt-1"
                                                            style="display:none;">
                                                            This field is required.
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="px-5 py-6">
                                                    <button id="retrait-button" type="submit"
                                                        class="text-center text-white w-full border h-[47px] bg-green-500 rounded-[37px] hover:bg-green-700">
                                                        Remove </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        const depotRoute = "{{ route('get-payment.depot') }}";
        const retraitRoute = "{{ route('transfert-payment.retrait') }}";

        document.addEventListener('DOMContentLoaded', function() {
            $('#country-select').on('change', function() {
                const selectedValue = $(this).val();

                if (selectedValue === '' || selectedValue === 'other') {
                    $('#indicatif-input').val('');
                    $('#indicatif-input').prop('readonly', false);
                } else {
                    $('#indicatif-input').val(selectedValue);
                    $('#indicatif-input').prop('readonly', true);
                }
            });
        });
    </script>

</body>

</html>
