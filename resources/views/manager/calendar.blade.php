@extends('layouts.app')

@section('title', 'Platform Calendar')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid px-0">
    <h1 class="text-center mb-4" style="font-weight:800; font-size:32px;">VERTEXGRAD Calendar </h1>
<!-- شريط التحكم الأعلى -->
<!-- شريط التحكم الأعلى مع الانعكاس -->
<div class="d-flex justify-content-between align-items-center mb-3 px-3">
    <!-- أزرار العرض على اليسار -->
    <div class="d-flex gap-2">
        <button id="monthViewBtn" class="btn btn-outline-secondary btn-sm">Month</button>
        <button id="weekViewBtn" class="btn btn-outline-secondary btn-sm">Week</button>
        <button id="dayViewBtn" class="btn btn-outline-secondary btn-sm">Day</button>

    </div>

    <!-- عنوان الشهر/اليوم/الأسبوع في الوسط -->
    <div>
        <span id="currentViewLabel" class="h5 fw-bold"></span>
    </div>

    <!-- أزرار التنقل على اليمين -->
    <div class="d-flex gap-2">
        <button id="prevBtn" class="btn btn-outline-primary">&lt; Previous</button>
        <button id="nextBtn" class="btn btn-outline-primary">Next &gt;</button>
        
    </div>
</div>



    <!-- تقويم -->
    <div class="calendar-container border shadow-sm mx-3" style="background:#fff; min-height:70vh;">
        <div id="calendarContent"></div>
    </div>

    <!-- عرض الأحداث -->
    <div class="modal fade" id="modal-view-event" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Events on <span id="eventDateTitle"></span></h4>
                    <div id="modalEventsList"></div>
                    <div id="modalEventsControls" class="mt-2"></div>
                </div>
                <div class="modal-footer">
                    <button id="openAddEvent" class="btn btn-primary">Add Event</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة حدث -->
    <div class="modal fade" id="modal-view-event-add" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="add-event-form">
                    <div class="modal-body">
                        <h4>Add Event</h4>
                        <input name="title" class="form-control mb-2" placeholder="Title" required>
                        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                        <select name="color" class="form-control mb-2">
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="red">Red</option>
                        </select>
                        <select name="icon" class="form-control">
                            <option value="calendar">Calendar</option>
                            <option value="group">Group</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
/* =========================
   تقويم احترافي UI/UX
=========================== */
.calendar-container {
    width: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* ====== شريط التحكم الرئيسي ====== */
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding: 10px 15px;
    border-radius: 12px;
    background-color: #f8f9fa;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* ====== أزرار العرض على اليسار ====== */
.calendar-header .view-buttons {
    display: flex;
    gap: 8px;
}
.calendar-header .view-buttons button {
    font-size: 0.85rem;
    padding: 5px 14px;
    border-radius: 8px;
    border-width: 1.5px;
    transition: all 0.2s ease;
}
.calendar-header .view-buttons button:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}
.calendar-header .view-buttons button.active {
    background: #0e4984;
    border-color: #061523;
    color: #fff;
}

/* ====== عنوان الشهر/اليوم/الأسبوع في الوسط ====== */
#currentViewLabel {
    font-size: 1.25rem;
    font-weight: 600;
    text-align: center;
    color: #333;
}

/* ====== أزرار التنقل على اليمين ====== */
.calendar-header .nav-buttons {
    display: flex;
    gap: 8px;
}
.calendar-header .nav-buttons button {
    font-size: 0.85rem;
    padding: 5px 14px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.calendar-header .nav-buttons button:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}
#deleteEventsBtn {
    background-color: #dc3545;
    color: #fff;
    border: none;
}
#deleteEventsBtn:hover {
    background-color: #c82333;
}

/* ====== أيام الأسبوع ====== */
.weekdays {
    display: flex;
    gap: 2px;
    margin-bottom: 5px;
}
.weekdays div {
    flex: 1;
    background-color: #1a548d; /* اللون الأزرق */
    color: #fff;
    font-weight: 600;
    text-align: center;
    padding: 10px 0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.weekdays div:hover {
    background-color: #66b3ff;
    transform: translateY(-1px);
}

/* ====== خلايا الأيام ====== */
.day-cell {
    flex: 1 0 14.28%;
    border-radius: 10px;
    text-align: center;
    padding: 10px;
    font-weight: 600;
    box-sizing: border-box;
    min-height: 100px;
    background: #fafafa;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
    position: relative;
    cursor: pointer;
}
.day-cell.today {
    background-color: #a6469c; /* لون خفيف لليوم الحالي */
    border: 2px solid #3399ff;
}
.day-cell:hover {
    background-color: #f0f8ff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

/* ====== الأحداث ====== */
.event {
    font-size: 13px;
    margin-top: 5px;
    padding: 6px 10px;
    border-radius: 12px;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
    box-shadow: 1px 1px 4px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
.event:hover {
    transform: scale(1.08);
    opacity: 0.95;
}
.event.blue { background: linear-gradient(135deg,#3399ff,#66ccff); }
.event.green { background: linear-gradient(135deg,#28a745,#71e175); }
.event.red { background: linear-gradient(135deg,#dc3545,#ff7f7f); }

/* ====== صفوف الأسبوع ====== */
.week-row {
    display: flex;
    margin-bottom: 5px;
}
.week-row .day-cell {
    flex: 1;
    margin: 2px;
    min-height: 120px;
    border-radius: 10px;
    padding: 8px;
    background: #b7cdf3;
    border: 1px solid #e0e0e0;
}

/* ====== عرض اليوم ====== */
.day-view {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.day-view .day-cell {
    width: 100%;
    min-height: 80px;
    border-radius: 10px;
    padding: 10px;
    background: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
}

/* ====== مودال الأحداث ====== */
.modal-backdrop { display: none !important; }
.tooltip-inner { max-width: 250px; text-align: left; font-size: 0.9rem; }

/* نصوص */
h4,h5 { font-weight: 700; color: #222; }
</style>


<script>
document.addEventListener('DOMContentLoaded', function(){
    const months=['January','February','March','April','May','June','July','August','September','October','November','December'];
    const daysOfWeek=['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    let currentMonth=0;
    let currentYear=2026;
    let currentView='month';
    let events={};
    let selectedDate='';

    const calendarContent=document.getElementById('calendarContent');
    const viewModal=new bootstrap.Modal(document.getElementById('modal-view-event'));
    const addModal=new bootstrap.Modal(document.getElementById('modal-view-event-add'));

    async function fetchEvents(){
        const res=await fetch('{{ url("manager/calendar/events") }}');
        events=await res.json();
        renderCalendar();
    }

    function renderCalendar(){
        calendarContent.innerHTML='';
        const label=document.getElementById('currentViewLabel');

        if(currentView==='month'){
            label.innerText=`${months[currentMonth]} ${currentYear}`;
            const weekdaysRow=document.createElement('div');
            weekdaysRow.className='weekdays bg-light border-bottom';
            daysOfWeek.forEach(d=>weekdaysRow.innerHTML+=`<div>${d}</div>`);
            calendarContent.appendChild(weekdaysRow);

            const daysContainer=document.createElement('div');
            daysContainer.className='days flex-wrap d-flex';
            const firstDay=new Date(currentYear,currentMonth,1).getDay();
            const lastDate=new Date(currentYear,currentMonth+1,0).getDate();

            for(let i=0;i<firstDay;i++) daysContainer.innerHTML+='<div class="day-cell"></div>';
            for(let i=1;i<=lastDate;i++){
                const key=`${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                const dayDiv=document.createElement('div');
                dayDiv.className='day-cell';
                dayDiv.dataset.date=key;
                let html=`<b>${i}</b>`;
                if(events[key]) events[key].forEach(e=>{
                    html+=`<div class="event ${e.color}" data-bs-toggle="tooltip" title="${e.description}">${e.title}</div>`;
                });
                dayDiv.innerHTML=html;
                dayDiv.addEventListener('click',()=>openDay(key));
                daysContainer.appendChild(dayDiv);
            }
            calendarContent.appendChild(daysContainer);
        } else if(currentView==='week'){
            label.innerText=`Week of ${months[currentMonth]} ${currentYear}`;
            const weekRow=document.createElement('div');
            weekRow.className='week-row';
            for(let i=1;i<=7;i++){
                const key=`${currentYear}-${String(currentMonth+1).padStart(2,'0')}-${String(i).padStart(2,'0')}`;
                const dayDiv=document.createElement('div');
                dayDiv.className='day-cell';
                dayDiv.innerHTML=`<b>${daysOfWeek[i-1]}</b><br><small>${i}</small>`;
                if(events[key]) events[key].forEach(e=>{
                    dayDiv.innerHTML+=`<div class="event ${e.color}" data-bs-toggle="tooltip" title="${e.description}">${e.title}</div>`;
                });
                dayDiv.addEventListener('click',()=>openDay(key));
                weekRow.appendChild(dayDiv);
            }
            calendarContent.appendChild(weekRow);
        } else {
            label.innerText=`Day of ${months[currentMonth]} ${currentYear}`;
            const dayDiv=document.createElement('div');
            dayDiv.className='day-view';
            const key=`${currentYear}-${String(currentMonth+1).padStart(2,'0')}-01`;
            const dayCell=document.createElement('div');
            dayCell.className='day-cell';
            dayCell.innerHTML=`<b>1</b>`;
            if(events[key]) events[key].forEach(e=>{
                dayCell.innerHTML+=`<div class="event ${e.color}" data-bs-toggle="tooltip" title="${e.description}">${e.title}</div>`;
            });
            dayCell.addEventListener('click',()=>openDay(key));
            dayDiv.appendChild(dayCell);
            calendarContent.appendChild(dayDiv);
        }

        // تفعيل Bootstrap tooltip لكل الأحداث
        const tooltipTriggerList=[].slice.call(calendarContent.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el=>new bootstrap.Tooltip(el));
    }

    function openDay(date){
        selectedDate=date;
        document.getElementById('eventDateTitle').innerText=date;
        const list=document.getElementById('modalEventsList');
        list.innerHTML='';
        const controls=document.getElementById('modalEventsControls');
        controls.innerHTML='';

        if(events[date]){
            events[date].forEach(e=>{
                const div=document.createElement('div');
                div.className='event '+e.color+' d-flex align-items-center mb-1';
                const checkbox=document.createElement('input');
                checkbox.type='checkbox';
                checkbox.value=e.id;
                checkbox.className='me-2';
                div.appendChild(checkbox);
                div.appendChild(document.createTextNode(e.title));
                list.appendChild(div);
            });

            const selectAllBtn=document.createElement('button');
            selectAllBtn.textContent='Select All';
            selectAllBtn.className='btn btn-sm btn-secondary me-2';
            selectAllBtn.onclick=()=>{ list.querySelectorAll('input[type="checkbox"]').forEach(cb=>cb.checked=true); };

            const deleteSelectedBtn=document.createElement('button');
            deleteSelectedBtn.textContent='Delete Selected';
            deleteSelectedBtn.className='btn btn-sm btn-danger me-2';
            deleteSelectedBtn.onclick=()=>deleteEvents(Array.from(list.querySelectorAll('input[type="checkbox"]:checked')).map(cb=>cb.value));

            controls.appendChild(selectAllBtn);
            controls.appendChild(deleteSelectedBtn);

        } else { list.innerHTML='<i>No events</i>'; }

        viewModal.show();
    }

    async function deleteEvents(ids){
        if(ids.length===0) return alert('No events selected');
        const res=await fetch('{{ url("manager/calendar/delete-events") }}',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
            body:JSON.stringify({ids})
        });
        const data=await res.json();
        if(data.success){ fetchEvents(); openDay(selectedDate); } else alert('Failed to delete events');
    }

    document.getElementById('openAddEvent').addEventListener('click',()=>{ viewModal.hide(); addModal.show(); });
    const addEventForm=document.getElementById('add-event-form');
    if(!addEventForm.dataset.listenerAdded){
        addEventForm.addEventListener('submit', async e=>{
            e.preventDefault();
            const res=await fetch('{{ url("manager/calendar/add-event") }}',{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
                body:JSON.stringify({
                    title:e.target.title.value,
                    description:e.target.description.value,
                    color:e.target.color.value,
                    icon:e.target.icon.value,
                    event_date:selectedDate
                })
            });
            const data=await res.json();
            if(data.success){ addEventForm.reset(); addModal.hide(); fetchEvents(); } else alert('Failed to save event!');
        });
        addEventForm.dataset.listenerAdded="true";
    }

    document.getElementById('prevBtn').addEventListener('click',()=>{ currentMonth--; if(currentMonth<0){currentMonth=11; currentYear--;} renderCalendar(); });
    document.getElementById('nextBtn').addEventListener('click',()=>{ currentMonth++; if(currentMonth>11){currentMonth=0; currentYear++;} renderCalendar(); });

    document.getElementById('monthViewBtn').addEventListener('click',()=>{currentView='month';renderCalendar();});
    document.getElementById('weekViewBtn').addEventListener('click',()=>{currentView='week';renderCalendar();});
    document.getElementById('dayViewBtn').addEventListener('click',()=>{currentView='day';renderCalendar();});

    fetchEvents();
});

document.addEventListener('DOMContentLoaded', function () {

    const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    let currentMonth = 0;
    let currentYear = 2026;
    let events = {};

    async function fetchEvents() {
        const res = await fetch('{{ url("manager/calendar/events") }}');
        events = await res.json();
        renderCalendar();
    }

    function renderCalendar() {
        document.getElementById('currentViewLabel').innerText = months[currentMonth] + ' ' + currentYear;
        // هنا ضع الكود الخاص برسم الأيام...
    }

    // زر حذف كل أحداث الشهر
    const deleteBtn = document.getElementById('deleteEventsBtn');
    deleteBtn.addEventListener('click', async () => {

        if(!confirm(`Are you sure you want to delete ALL events for ${months[currentMonth]} ${currentYear}?`)) return;

        // نجمع كل الـ IDs للأحداث في الشهر الحالي
        const ids = [];
        for(let date in events){
            if(date.startsWith(`${currentYear}-${String(currentMonth+1).padStart(2,'0')}`)){
                events[date].forEach(e => ids.push(e.id));
            }
        }

        if(ids.length === 0){
            alert('No events found for this month!');
            return;
        }

        // طلب الحذف
        const res = await fetch('{{ url("manager/calendar/delete-events") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ ids })
        });

        const data = await res.json();
        if(data.success){
            alert('All events for the month have been deleted!');
            fetchEvents(); // إعادة تحميل الأحداث بعد الحذف
        } else {
            alert('Failed to delete events!');
        }

    });

    fetchEvents();
});


</script>
@endsection
