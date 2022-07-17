<html>
<head>
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <style>
        @page { margin: 0px; }

        .heading {
            margin-top: 5px;
            margin-left: 5px;
            margin-right: 15px;
            margin-bottom: 0;
            float: left;
            
        }

        h4 {
            margin-top: 0;
            margin-left: 45px;
            margin-bottom: 0;
        }
        .type {
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 0px;
            font-size: 25px;
            font-weight: bold;
        }
        .container {
            font-family: arial;
            outline: solid 1px black;
            margin: 5px 5px 5px 5px;
            border-radius: 15px;
        }
        .qrcode{
            margin-top: 5px;
            margin-left: 30px;
            margin-right: 5px;
            margin-bottom: 0px;
            float: left;
        }
        .emblem {
            width: 25px;  
            height: 35px;  
            margin-left: 10px;
            margin-top: 15px;
            float: left;
        }
        .content {
            
            margin-left: 0;
        }
        .content p {
            margin: 2px;
        }
        .content small {
            margin-top: 5px;
            font-size: 10px;
        }
        .code {
            margin-left: 30px;
            margin-top: 15px;
            margin-bottom: 0;
            font-size: 10px;
        }
        .sign {
            margin-top: 30px;
            margin-bottom: 0;
            margin-left: 280px;
            font-size: 10px;
        }
        .ref {
            font-size: 10px;
            float: left;
            margin-top: 0px;
            margin-bottom: 10px;
            margin-right: 0;
            margin-left: 30px;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    @foreach(Auth::user()->workplace->vehicles as $vehicle)
        @if($vehicle->print_lock == false)
            <div class="container">
                <img class="emblem" src="{{asset('images/emblem.png')}}" >
                <h2 class="heading">Vehicle Fuel Supply Card</h2>
                <p class ="type">@if($vehicle->fuel_type == "Petrol") P @elseif($vehicle->fuel_type == "Diesel") D @elseif($vehicle->fuel_type == "Kerosene") K @endif/ {{ $vehicle->consumer_type }}</p>
                <h4>District Secretariat - Ampara</h4>
                
                <img class="qrcode" src="data:image/png;base64, {!! base64_encode(QrCode::size(130)->generate($vehicle->qrcode)) !!} ">
                <div class="content">
                    <p><b>Vehicle No:</b> {{ $vehicle->vehicle_no }}</p>
                    <p><b>Vehicle Type:</b> {{ $vehicle->vehicle_type }}</p>
                    <p><b>Owner Name:</b> {{ $vehicle->owner_name }}</p>
                    <p><b>Owner ID:</b> {{ $vehicle->owner_id }}</p>
                    <p><b>DS Division:</b> {{ substr($vehicle->workplace->name, 0, strpos($vehicle->workplace->name, "-")) }}</p>
                    <small>* Eligible once per {{ $vehicle->allowed_days }}  days.</small>
                </div>
                <p class="code">Code:</p>
                <p class="ref">Ref No: {{ $vehicle->ref_no }}</p>
                <p class="sign">...................................<br />Divisional Secretary</p>
            </div>
            <div class="page_break"></div>
            @php
            $thisVehicle = App\Vehicle::find($vehicle->id);
            $thisVehicle->print_lock = true;
            $thisVehicle->save();
            @endphp 
        @endif
    @endforeach
</body>
</html>