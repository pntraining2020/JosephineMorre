<html>

<head>
    <title>Time Tracker App</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/layout.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <form method="post" action="{{ url('user') }}" class="form">
            <div class="card text-center">
                <div class="card-header bg-primary">
                    <h2 class="text-default">Time Tracker</h2>
                </div>
                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                            Names
                        </button>
                        <ul class="dropdown-menu">
                            @foreach($users as $user)
                            <li><a href="{{ url('/user', $user->id) }}">{{ $user->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="text-info" id="time"></div>
                    <div>
                        <a class="btn btn-success btn-lg" id="in">Clock in</a>
                        <span id="inTime" class="text-danger"></span>
                    </div>
                    <div class="border">
                        <h3 class="text-info">Break</h3>
                        <div>
                            <a class="btn btn-warning btn-sm" id="start">Start</a>
                            <span id="startTime" class="text-danger"></span>
                        </div>
                        <div>
                            <a class="btn btn-danger btn-sm" id="end">End</a>
                            <span id="endTime" class="text-danger"></span>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success btn-lg" id="out">Clock out</button>
                        <span id="outTime" class="text-danger"></span>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    <div>
                        <p>TOTAL TIME WORKED :
                            <span class="text-danger" name="total" id="total"></span></p>
                    </div>
                    <div>
                        <p>HOURS LEFT BEFORE TIMEOUT :
                            <span class="text-danger" name="left" id="left"></span></p>
                    </div>
                    <div>
                        <p>TOTAL BREAKS USED :
                            <span class="text-danger" name="breaks" id="breaks"></span></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.1.0.min.js"
    integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {

    window.setInterval(startTime, 1000);

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        // add a zero in front of numbers<10
        m = checkTime(m);
        document.getElementById('time').innerHTML = h + ":" + m;
        t = setTimeout(function() {
            startTime()
        }, 500);
    }

    function start() {
        $('#start').attr('disabled', 'disabled');
        $('#end').attr('disabled', 'disabled');
        $('#out').attr('disabled', 'disabled');
    }

    function displayTime(id) {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        m = checkTime(m);
        document.getElementById(id).innerHTML = h + ":" + m;
    }

    function getDifference() {
        var date1 = parseInt($('#inTime').text(), 10);
        var date2 = parseInt($('#outTime').text(), 10);
        // var hours = Math.abs(date1 - date2) / 36e5;
        var diffMs = (date1 - date2);
        var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
        var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
        diffHrs = checkTime(diffHrs);
        diffMins = checkTime(diffMins);
        document.getElementById('total').innerHTML = diffHrs + ":" + diffMins;
        document.getElementById('left').innerHTML = diffHrs + ":" + diffMins;
    }

    function getBreak() {
        var date1 = parseInt($('#startTime').text(), 10);
        var date2 = parseInt($('#endTime').text(), 10);
        // var hours = Math.abs(date1 - date2) / 36e5;
        var diffMs = (date1 - date2);
        var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
        var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
        diffHrs = checkTime(diffHrs);
        diffMins = checkTime(diffMins);
        document.getElementById('breaks').innerHTML = diffHrs + ":" + diffMins
        break;
    }

    function getLeft() {
        var date1 = parseInt($('#inTime').text(), 10);
        var date2 = parseInt($('#inTime').text(), 10);
        // var hours = Math.abs(date1 - date2) / 36e5;
        var diffMs = (date1 - date2);
        var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // hours
        var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes
        diffHrs = checkTime(diffHrs);
        diffMins = checkTime(diffMins);
        document.getElementById('total').innerHTML = diffHrs + ":" + diffMins;
    }

    start();
    startTime();

    $('#in').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#start').removeAttr('disabled');
        $('#out').removeAttr('disabled');
        displayTime('inTime');
    })

    $('#start').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#end').removeAttr('disabled');
        displayTime('startTime');
    })

    $('#end').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#start').removeAttr('disabled');
        displayTime('endTime');
        getBreak();
    })

    $('#out').click(function() {
        $(this).attr('disabled', 'disabled');
        $('#in').removeAttr('disabled');
        start();
        displayTime('outTime');
        getDifference();
        $('#outTime').text('');
        $('#inTime').text('');
        $('#startTime').text('');
        $('#endTime').text('');
    })

})
</script>

</html>