<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100">
            {{ __('Mes séances réservées') }}
        </h2>
    </x-slot>

    <div class=" mx-auto p-6 space-y-6">

       

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left">Type de séance</th>
                        <th class="px-6 py-3 text-left">Type d'abonnement</th> 
                        <th class="px-6 py-3 text-left">Début</th>
                        <th class="px-6 py-3 text-left">Fin</th>
                        <th class="px-6 py-3 text-left">État paiement</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    @forelse ($events as $event)
        <tr>
            <td class="px-6 py-4">{{ ucfirst($event->TypeSeance) }}</td>
            <td class="px-6 py-4">
                {{ $event->Typepayment == 'subscription' ? 'Abonnement mensuel' : 'Paiement par séance' }}
            </td>
            <td class="px-6 py-4">{{ $event->start}}</td>
            <td class="px-6 py-4">{{ $event->end }}</td>
            <td class="px-6 py-4">
                @if($event->paid)
                    <span class="text-green-600 font-semibold">Payé</span>
                @else
                    <span class="text-red-600 font-semibold">Non payé</span>
                @endif
            </td>
            <td class="px-6 py-4 flex gap-2">
                @if(!$event->paid)
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Supprimer</button>
                    </form>

                    <form action="{{ route('events.update', $event->id) }}" method="POST" class="flex items-center gap-2" style="display:inline-flex;">
                        @csrf
                        @method('PUT')
                        <input type="datetime-local" name="start" value="{{ $event->start }}" class="border rounded p-1" required>
                        <input type="datetime-local" name="end" value="{{ $event->end}}" class="border rounded p-1" required>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Modifier</button>
                    </form>
                @else
                    <span class="text-gray-500 italic">Actions désactivées</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-600">Aucune séance trouvée.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>

    </div>
</x-app-layout>
