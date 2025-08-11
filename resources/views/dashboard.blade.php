<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100">
            {{ __('Réserver votre séance de Gym') }}
        </h2>
    </x-slot>

    <div class=" mx-auto p-6 space-y-8">

        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-4">Type de séance</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
               <button data-value="cardio" class="session-btn  border-black bg-red-400 text-white font-semibold py-3 rounded-lg hover:scale-105 transition transform">
    Cardio Training
    <span class="block text-sm mt-1">50 MAD</span>
</button>

<button data-value="musculation" class="session-btn  border-black bg-red-400 text-white font-semibold py-3 rounded-lg hover:scale-105 transition transform">
    Musculation
    <span class="block text-sm mt-1">60 MAD</span>
</button>

<button data-value="crossfit" class="session-btn  border-black bg-red-400 text-white font-semibold py-3 rounded-lg hover:scale-105 transition transform">
    CrossFit
    <span class="block text-sm mt-1">70 MAD</span>
</button>

<button data-value="yoga" class="session-btn  border-black bg-red-400 text-white font-semibold py-3 rounded-lg hover:scale-105 transition transform">
    Yoga
    <span class="block text-sm mt-1">40 MAD</span>
</button>


            </div>
        </div>

        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-4">Choisissez votre créneau</h3>
             <form action="/event/store" method="post" class="mb-2 hidden">
                        @csrf
                        <input type="datetime-local" name="start" id="start">
                        <input type="datetime-local" name="end" id="end">
                        <input type="text" name="TypeSeance" id="TypeSeance">
                        <input type="text" name="Typepayment" id="Typepayment">

                        <button type="submit" id="submitBtn">Submit</button>
                    </form>
                    <div class="h-[92vh]" id='calendar'></div>
            <p id="selectedDate" class="mt-3 text-green-700 dark:text-green-400 font-medium"></p>
        </div>




        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-semibold mb-4">Mode de paiement</h3>
            <div class="flex gap-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment_method" value="one_time" class="accent-green-500 w-5 h-5 payment" />
                    <span class="text-gray-800 dark:text-gray-200 font-semibold">Paiement par séance</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="radio" name="payment_method" value="subscription" class=" w-5 h-5 payment" />
                    <span class="text-gray-800 dark:text-gray-200 font-semibold">Abonnement mensuel</span>
                </label>
            </div>
        </div>

        <div class="text-center">
            <button id="submitreserv" class="bg-red-400 text-white font-bold py-3 px-7 rounded-lg shadow-lg transition transform hover:scale-105">
                Réserver et Payer
            </button>
        </div>
    </div>

   

    
</x-app-layout>
