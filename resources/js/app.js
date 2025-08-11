import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener("DOMContentLoaded", async function () {
    let response = await axios.get('/get-events');
    let events = response.data.events;

    let calendarEl = document.getElementById("calendar")
    let startInput = document.getElementById('start')
    let endInput = document.getElementById('end')
    let submitBtnHidden = document.getElementById('submitBtn') 
    let submitReservBtn = document.getElementById('submitreserv') 
    let sessionButtons = document.querySelectorAll('.session-btn')
let payment = document.querySelectorAll('.payment')
let TypeSeance = document.getElementById('TypeSeance')
let Typepayment = document.getElementById('Typepayment')

    sessionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            sessionButtons.forEach(b => b.classList.remove('border-2'))
            btn.classList.add('border-2');
            let type = btn.getAttribute('data-value');
            TypeSeance.value = type
            // console.log(TypeSeance.value);
            
        });
    });

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridDay',
        slotMinTime: "09:00:00",
        slotMaxTime: "19:00:00",
        nowIndicator: true,
        selectable: true,
        editable: true,
        selectMirror: true,
        selectOverlap: false,
        weekends: true,
        events: events,
        select: (info) => {
            startInput.value = info.startStr.slice(0, 19);
            endInput.value = info.endStr.slice(0, 19);
            selectedDate.textContent = 'Créneau choisi : '  +startInput.value + ' - ' + endInput.value ;
        }
    });

    payment.forEach(e => {
        e.addEventListener('click', ()=>{
            Typepayment.value = e.value
        })
    })



    calendar.render();

    submitReservBtn.addEventListener('click', () => {
        
    
        submitBtnHidden.click();
    });
});
