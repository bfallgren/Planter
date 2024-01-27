@extends('layout')
@section('content') 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlantScape Event Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>
    <div class="container mt-5" style="max-width: 700px">
        <h2 class="h2 text-center mb-5 border-bottom pb-3">Events Calendar</h2>
        <div id='calendar'></div>
    </div>
    {{-- Scripts --}}
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
         $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            defaultView: 'month',
            eventBackgroundColor: "green",
            eventTextColor: "yellow",
            aspectRatio: 1,
            navLinks: true,
            displayEventTime: false,
            header: {
                left: 'prev,next,prevYear,nextYear',
                center: 'title,today',
                right: 'month,list'
            },
            events : [
               
                @foreach($events as $event)
                {
                    title : '{{ $event->activity_type . ' ' . $event->descr }}',
                    start : '{{ $event->entered_at }}',
                 //   url: 'http://vb.planter.test/events/'
                },
                @endforeach
            ],
            eventClick: function(event) {
                if (event.url) {
                    window.open(event.url,"_self");
                    return false;
                }
            }
        });
    });
    </script>
</body>
</html>
@endsection