<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                <div x-data="{ active: @js($name ?? 'depot') }" class="w-full p-4 bg-white rounded shadow">
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
                                        <form action="">
                                            <div class="mt-3 space-y-2">
                                                <div class="inputbox">
                                                    <label for=country" class="block">
                                                        <span>Country</span>
                                                        <select name="country" id="country-select"
                                                            class="mt-1 select2 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                            <option>Choose</option>
                                                            @foreach ($countries as $country)
                                                                <option class="" value="{{ $country->id }}"
                                                                    data-indicatif="{{ $country->indicatif }}"
                                                                    data-currency="{{ $country->devise_id }}">
                                                                    {{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                </div>

                                                <div class="inputbox">
                                                    <label for="currency" class="block">
                                                        <span>Enter your currency</span>
                                                        <select name="currency" id="currency-input"
                                                            class="select2 not-first:mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0">
                                                            <option>Choose</option>
                                                            @foreach ($currencies as $currency)
                                                                <option value="{{ $currency->id }}">
                                                                    {{ $currency->code_iso }}</option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                </div>

                                                <div class="inputbox">
                                                    <label for="number" class="block">
                                                        <span>Phone number</span>
                                                        <div class="flex gap-2">
                                                            <input type="text" id="indicatif-input"
                                                                class="mt-1 w-15 rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                                placeholder="" disabled />
                                                            <input min="0" type="text" id="input-number" name="number"
                                                                class="mt-1 w-100 block rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                                placeholder="" />
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="d-flex flex-row">
                                                    <label for="amount" class="block">
                                                        <span>Amounts</span>
                                                        <input min="0" type="text" id="input-amount" name="amount"
                                                            class="mt-1 block w-full rounded-md border-transparent bg-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0"
                                                            placeholder="" />
                                                    </label>
                                                </div>

                                                <div class="block">
                                                    <div class="mt-2">
                                                        <div>
                                                            <label class="inline-flex items-center">
                                                                <input type="checkbox"
                                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:ring-offset-0"
                                                                    checked />
                                                                <span class="ml-2">Acceptez-vous avoir bien fournir
                                                                    les
                                                                    informations
                                                                    !</span>
                                                            </label>
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
                                <div class="w-125 h-80" id="retrait">
                                    <div class="mt-4 mx-4">
                                        <div class="text-center font-bold text-base">
                                            <h5>Veuillez Remplire les champs ci-dessous</h5>
                                        </div>

                                        <div class="mt-3">
                                            <div class="inputbox"> <input type="text" name="name"
                                                    class="form-control" required="required"> <span>Cardholder
                                                    Name</span> </div>
                                            <div class="inputbox"> <input type="text" name="name" min="1"
                                                    max="999" class="form-control" required="required"> <span>Card
                                                    Number</span> <i class="fa fa-eye"></i> </div>
                                            <div class="d-flex flex-row">
                                                <div class="inputbox"> <input type="text" name="name"
                                                        min="1" max="999" class="form-control"
                                                        required="required">
                                                    <span>Expiration
                                                        Date</span>
                                                </div>
                                                <div class="inputbox"> <input type="text" name="name"
                                                        min="1" max="999" class="form-control"
                                                        required="required">
                                                    <span>CVV</span>
                                                </div>
                                            </div>
                                            <div class="px-5 pay">
                                                <button class="btn btn-success btn-block">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @php
        $currencyMap = $currencies->pluck('code_iso', 'id');
    @endphp

    <script>
        window.appData = window.appData || {};
        window.appData.currencyMap = @json($currencyMap);
    </script>
</body>

</html>
