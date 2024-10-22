<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var downloadButtonEl = document.getElementById('download-button-container');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: false,
                dateClick: function(info) {
                    window.location.href = '/absences/' + info.dateStr;
                },
                datesSet: function(info) {
                    // Ottieni il mese corrente dal calendario e aggiungi 1 perché il mese parte da 0 (gennaio è 0)
                    var month = info.view.currentStart.getMonth() + 1;
                    var year = info.view.currentStart.getFullYear();

                    // Ottieni il nome del mese in italiano con la prima lettera maiuscola
                    var monthName = new Intl.DateTimeFormat('it-IT', { month: 'long' }).format(info.view.currentStart);
                    monthName = monthName.charAt(0).toUpperCase() + monthName.slice(1);

                    // Crea il pulsante di download dinamico con il link corretto
                    downloadButtonEl.innerHTML = `
                        <a href="/reports/monthly/download?year=${year}&month=${month}" class="btn btn-primary">
                            Scarica Report per ${monthName} ${year}
                        </a>
                    `;
                }
            });

            calendar.render();
        });
    </script>
</head>
<body>
    <div style="width: 100%">
        <!-- Contenitore per il pulsante di download del report mensile -->
        <div id="download-button-container" style="text-align: center; margin-top: 20px;"></div>
        
        <!-- Calendario -->
        <div id='calendar' style="width: 50%; margin: auto; margin-top: 5%;"></div>

    </div>
</body>
</html>
