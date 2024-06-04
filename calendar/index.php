<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish and Responsive Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        margin: 0;
        padding: 0;

    }

    #calendar {
        margin: 20px auto;
        max-width: 90%;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 900px;
    }

    .fc-event {
        background-color: rgba(0, 123, 255, 0.2);
        border: none;
        color: #fff;
        border-radius: 6px;
        width: 10px;
        height: 10px;
        margin: 0 auto;
    }

    .fc-event:hover {
        background-color: rgba(0, 123, 255, 0.4);
    }

    .month-events {
        padding: 20px;
        background-color: wheat;
        font-weight: bold;
        padding: 10px;
        border-radius: 5px;
    }

    .month-events ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .month-events li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .month-events li:last-child {
        border-bottom: none;
    }

    /* Target mobile devices with a max width of 768px */
    @media only screen and (max-width: 768px) {

        /* Adjust font sizes for mobile devices */
        .fc-event {
            font-size: 1em;
        }

        .fc-title {
            font-size: 1em;
        }

        .month-events li {
            font-size: 0.9em;
        }
    }
    </style>
</head>

<body>

     <nav class="navbar navbar-expand-lg bg-body-tertiary text-center  fs-5">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="../icym_25.png" alt="Logo" id="navbar-logo" style="max-height: 100px; max-width: 100px;" onerror="this.onerror=null;this.src='alternative_logo.png';">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../posts/">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../youcat">YouCat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../news/">Daily News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Coming Events Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../jobs/">Job Offers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../magazines/">Magazines</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../gallery/">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div id="calendar"></div>
    <div class="month-events container">
        <h4 id="month-title">
            </h2>
            <ul id="month-events-list"></ul>
    </div>

    <script>
    $(document).ready(function() {
        var calendar = $('#calendar').fullCalendar({
            editable: false, // Disable editing
            events: "../admin/calendar/fetch-event.php",
            displayEventTime: false,
            eventRender: function(event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
                element.find('.fc-title').css('font-size', '1.2em');
                element.html(
                    '<div style="width: 20px; height: 20px; border-radius: 50%; background-color: rgba(0, 123, 255, 0.2);"></div>'
                );
            },
            selectable: false, // Disable date selection
            selectHelper: false,
            eventDrop: null,
            eventClick: null,
            validRange: {
                start: '2024-01-01',
                end: '2025-01-01'
            },
            viewRender: function(view, element) {
                var month = view.intervalStart.format('MMMM YYYY');
                $('#month-title').text(month);
                $('#month-events-list').html('');
                $.ajax({
                    type: "POST",
                    url: "../admin/calendar/fetch-event.php",
                    data: {
                        month: month
                    },
                    success: function(data) {
                    var events = JSON.parse(data);
                    $.each(events, function(index, event) {
                        if (moment(event.start, "YYYY-MM-DD HH:mm:ss").format(
                                "YYYY-MM") == view.intervalStart.format(
                                "YYYY-MM")) {
                            var formattedStart = moment(event.start,
                                "YYYY-MM-DD HH:mm:ss").format("DD-MM-Y");
                            $('#month-events-list').append('<li>' +
                                formattedStart + ' - ' + event.title +
                                '</li>');
                        }
                    });
                }
            });
        }
    });
});
    </script>
</body>

</html>




<script>
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        ...viewRender: function(view, element) {
            var month = view.intervalStart.format('MMMM YYYY');
            $('#month-title').text(month);
            $('#month-events-list').html('');
            $.ajax({
                type: "POST",
                url: "../admin/calendar/fetch-event.php",
                data: {
                    month: month
                },
                success: function(data) {
                    var events = JSON.parse(data);
                    $.each(events, function(index, event) {
                        if (moment(event.start, "YYYY-MM-DD HH:mm:ss").format(
                                "YYYY-MM") == view.intervalStart.format(
                                "YYYY-MM")) {
                            var formattedStart = moment(event.start,
                                "YYYY-MM-DD HH:mm:ss").format("DD-MM-Y");
                            $('#month-events-list').append('<li>' +
                                formattedStart + ' - ' + event.title +
                                '</li>');
                        }
                    });
                }
            });
        }
    });
});
</script>