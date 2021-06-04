
<table style="table-layout:fixed">
    <thead>
    <tr >
    <th style="text-align: center;word-wrap: break-word;font-size: 12px;font-weight: bold" colspan="8">Daily Progress of Issued Passes for out of District Travelling During the Travel Restriction Period - Ampara District</th>
    </tr>
    <tr>
    <th colspan="2"><b>Date: {{date('d/m/Y')}}</b></th>
    </tr>
    <tr>
        <th rowspan="2" style="vertical-align:center"><b>S/No.</b></th>
        <th rowspan="2" style="vertical-align:center"><b>DS Division</b></th>
        <th colspan="3" style="text-align:center"><b>No. of Issued Passes Today</b></th>
        <th colspan="3" style="text-align:center"><b>Total No. of Issued Passes to Date</b></th>
    </tr>
    <tr>
        
        <th>Private Travel</th>
        <th>Essential Food</th>
        <th>Total</th>
        <th>Private Travel</th>
        <th>Essential Food</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    
    @foreach($workplaces as $workplace)
        @if($loop->index == 0)
            @continue
        @endif
        {{ $today_tot = 0 }}
        {{ $today_1 = 0 }}
        {{ $today_2 = 0 }}
        {{ $overall_tot = 0 }}
        {{ $overall_1 = 0 }}
        {{ $overall_2 = 0 }}
        @foreach($workplace->travelpasses as $travelpass)
            @if(($travelpass->created_at->isToday()) && (($travelpass->travelpass_status == "TRAVEL PASS ISSUED") || ($travelpass->travelpass_status == "TRAVEL PASS RECEIVED")))
                @if($travelpass->travelpass_type == "foods_goods")
                    {{ $today_1 += 1 }}
                    {{ $overall_1 += 1 }}
                @elseif($travelpass->travelpass_type == "private_trans")
                    {{ $today_2 += 1 }}
                    {{ $overall_2 += 1 }}
                @endif
            
            @elseif(($travelpass->travelpass_status == "TRAVEL PASS ISSUED") || ($travelpass->travelpass_status == "TRAVEL PASS RECEIVED"))

                @if($travelpass->travelpass_type == "foods_goods")
                    {{ $overall_1 += 1 }}
                @elseif($travelpass->travelpass_type == "private_trans")
                    {{ $overall_2 += 1 }}
                @endif

            @endif

        @endforeach
        {{ $today_tot = $today_1 + $today_2 }}
        {{ $overall_tot += $overall_1 + $overall_2 }}
        <tr>
            <td style="text-align: center">{{$loop->index}}</td>
            <td>{{ substr($workplace->name, 0, strpos($workplace->name, '-'))}}</td>
            <td>{{ $today_2 }}</td>
            <td>{{ $today_1 }}</td>
            <td>{{ $today_tot }}</td>
            <td>{{ $overall_2 }}</td>
            <td>{{ $overall_1 }}</td>
            <td>{{ $overall_tot }}</td>

        </tr>

        
        
        
       
    @endforeach
    </tbody>
</table>


