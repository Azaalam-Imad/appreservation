<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100">
            Tableau de bord - Admin
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-md">

            <form method="post" class="mb-2 hidden" id="deleteFormAdmin">
                @csrf
                @method('DELETE')
                <button id="deleteBtnAdmin" type="submit">Submit</button>
            </form>

            <form method="post" class="mb-2 hidden" id="updateFormAdmin">
                @csrf
                @method('PUT')
                <input type="datetime-local" name="updateStart" id="updateStartAdmin" required>
                <input type="datetime-local" name="updateEnd" id="updateEndAdmin" required>
                <button id="updateBtnAdmin" type="submit">Submit</button>
            </form>

            <div id="calendarAdmin"></div>

            <h3 class="text-xl font-semibold mb-4">Liste des utilisateurs et leurs séances</h3>
            <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="border p-2">Nom</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Type Séance</th>
                        <th class="border p-2">Type Abonnement</th>
                        <th class="border p-2">Paiement</th>
                        <th class="border p-2">Prix</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @foreach ($user->events as $event)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <td class="border p-2">{{ $user->name }}</td>
                                <td class="border p-2">{{ $user->email }}</td>
                                <td class="border p-2">{{ $event->TypeSeance }}</td>
                                <td class="border p-2">{{ $event->Typepayment ?? 'Non spécifié' }}</td>
                                <td class="border p-2">
                                    @if ($event->paid)
                                        <span class="text-green-600 font-bold">Payé</span>
                                    @else
                                        <span class="text-red-600 font-bold">Non payé</span>
                                    @endif
                                </td>
                                <td class="border p-2">
                                    @if ($event->TypeSeance === 'cardio')
                                        50 MAD
                                    @elseif($event->TypeSeance === 'musculation')
                                        60 MAD
                                    @elseif($event->TypeSeance === 'crossfit')
                                        70 MAD
                                    @elseif($event->TypeSeance === 'yoga')
                                        40 MAD
                                    @else
                                        0 MAD
                                    @endif
                                </td>
                                <td class="border p-2 flex gap-2">
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            let response = await axios.get("/get-events");
            let events = response.data.events;
            let nowDate = new Date();

            let deleteForm = document.getElementById("deleteFormAdmin");
            let deleteBtn = document.getElementById("deleteBtnAdmin");

            let updateForm = document.getElementById("updateFormAdmin");
            let updateStart = document.getElementById("updateStartAdmin");
            let updateEnd = document.getElementById("updateEndAdmin");
            let updateBtn = document.getElementById("updateBtnAdmin");

            var calendar = new FullCalendar.Calendar(document.getElementById("calendarAdmin"), {
                headerToolbar: {
                    left: "prev,next,dayGridMonth,timeGridWeek,timeGridDay",
                    center: "title",
                    right: "listMonth,listWeek,listDay",
                },
                initialView: "timeGridDay",
                slotMinTime: "09:00:00",
                slotMaxTime: "19:00:00",
                nowIndicator: true,
                selectable: true,
                selectMirror: true,
                selectOverlap: false,
                weekends: true,
                editable: true,
                events: events,
                selectAllow: (info) => info.start >= nowDate,

                eventClick: (info) => {
                    deleteForm.action = `/admin/event/${info.event._def.publicId}`;
                    
                        deleteBtn.click();
                    
                },

                eventResize: (info) => updateEvent(info),
                eventDrop: (info) => updateEvent(info),
            });

            calendar.render();

            function updateEvent(info) {
                let eventId = info.event._def.publicId;
                let start = info.event._instance.range.start;
                let end = info.event._instance.range.end;

                updateStart.value = start.toISOString().slice(0, 16); 
                updateEnd.value = end.toISOString().slice(0, 16);

                updateForm.action = `/admin/event/${eventId}`;
                updateBtn.click();
            }
        });
    </script>
</x-app-layout>
