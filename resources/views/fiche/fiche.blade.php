<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #6</title>

    <style>
      html,
      body {
        margin: 10px;
        padding: 10px;
        font-family: sans-serif;
      }
      h1,
      h2,
      h3,
      h4,
      h5,
      h6,
      p,
      span,
      label {
        font-family: sans-serif;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0px !important;
      }
      table thead th {
        height: 28px;
        text-align: left;
        font-size: 16px;
        font-family: sans-serif;
      }
      table,
      th,
      td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
      }

      .heading {
        font-size: 24px;
        margin-top: 12px;
        margin-bottom: 12px;
        font-family: sans-serif;
      }
      .small-heading {
        font-size: 18px;
        font-family: sans-serif;
      }
      .total-heading {
        font-size: 18px;
        font-weight: 700;
        font-family: sans-serif;
      }
      .order-details tbody tr td:nth-child(1) {
        width: 20%;
      }
      .order-details tbody tr td:nth-child(3) {
        width: 20%;
      }

      .text-start {
        text-align: left;
      }
      .text-end {
        text-align: right;
      }
      .text-center {
        text-align: center;
      }
      .company-data span {
        margin-bottom: 4px;
        display: inline-block;
        font-family: sans-serif;
        font-size: 14px;
        font-weight: 400;
      }
      .no-border {
        border: 1px solid #fff !important;
      }
      .bg-blue {
        background-color: #414ab1;
        color: #fff;
      }
    </style>
  </head>
  <body>


@php
    use Carbon\Carbon;

    // $date attendu sous forme MM-YYYY
    $formattedMonth = Carbon::createFromFormat('m-Y', $date)
        ->locale('fr')
        ->translatedFormat('F Y');
@endphp


    <table class="order-details">
      <thead>
        <tr>
          <th width="50%" colspan="2">
            <h2 class="text-start">Inspire Academy</h2>
            <h2 class="text-start">FICHE DE PRESENCE</h2>
             <h2 class="text-start">{{$course->name}}</h2>
          </th>
          <th width="50%" colspan="2" class="text-end company-data">
         
            <span>Inspire Academy</span> <br />

            <span>Zip code : 64200</span> <br />
            <span>Address: 25 All. du Moura, Biarritz</span> <br />
            <span>Phone : 05 40 07 55 12</span>
          </th>
        </tr>
        <tr class="bg-blue">
          <th width="50%" colspan="2">Détails</th>
          <th width="50%" colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>NOM Prénom</td>
          <td>
          @foreach($students as $student)
           {{$student->last_name}} {{$student->first_name}}
          @endforeach
          
          </td>

          <td>Formateurs(s)</td>
          <td>{{$teacher->last_name}} {{$teacher->first_name}} </td>
        </tr>
        <tr>
          <td>Mois concerné</td>
          <td style="text-transform: capitalize;">
           {{ $formattedMonth }}
          </td>


          <td>Durée totale de la formation</td>
          <td>
           @php
        // Extract hours and minutes
        $hours = floor($course->total_hours);
        $minutes = ($course->total_hours - $hours) * 60;

        // Format minutes to two digits
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Output the time format
        $formattedHours = ($hours > 0 ? $hours . ' hr ' : '') . ($minutes > 0 ? $formatted_minutes . ' min' : '');
        echo "$formattedHours";
    @endphp
          </td>
        </tr>
      </tbody>
    </table>

    

    @php
    // Total des heures effectuées (somme des durées du tableau)
    $totalHours = $classes->sum('hours');

    $totalH = floor($totalHours);
    $totalM = round(($totalHours - $totalH) * 60);

    // Sécurité si on tombe sur 60 min
    if ($totalM === 60) {
        $totalH++;
        $totalM = 0;
    }
@endphp


    <table>
      <thead>
        <tr>
      
        </tr>
        <tr class="bg-blue">
          <th style="text-align: center; vertical-align: middle;" >Date</th>
          <th style="text-align: center; vertical-align: middle;" >Durée</th>
          <th style="text-align: center; vertical-align: middle;" >Heure</th>
          <th style="text-align: center; vertical-align: middle;" >En ligne</th>
          <th style="text-align: center; vertical-align: middle;" >Signature</th>
          <th style="text-align: center; vertical-align: middle;" >Signature du formateur</th>
          <th style="text-align: center; vertical-align: middle;" >Suivi du cours</th>
        </tr>
      </thead>
      <tbody>
       @foreach($classes as $lesson)
        <tr>
       
          <td style="text-align: center; vertical-align: middle;" width="13%">{{$lesson->date}}</td>
          <td style="text-align: center; vertical-align: middle;" width="4%"> @php
        // Extract hours and minutes
        $hours = floor($lesson->hours);
        $minutes = ($lesson->hours - $hours) * 60;

        // Format minutes to two digits
        $formatted_minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Output the time format
        $formattedHours = ($hours > 0 ? $hours . ' hr ' : '') . ($minutes > 0 ? $formatted_minutes . ' min' : '');
        echo "$formattedHours";
    @endphp</td>
           <td style="text-align: center; vertical-align: middle;" width="12%" class="fw-bold">
    {{ substr($lesson->start_time, 0, 5) }}/{{ substr($lesson->end_time, 0, 5) }}
</td>
          <td style="text-align: center; vertical-align: middle;" width="4%">
    @if($lesson->room_id == 102)
        Oui
    @else
        Non
    @endif
</td>

        
          <td style="text-align: center; vertical-align: middle;" width="10%" class="fw-bold"></td>
          <td style="text-align: center; vertical-align: middle;" width="10%" class="fw-bold"></td>
          <td width="47%" class="fw-bold">
         {{$lesson->report}}
          </td>

         
        </tr>

        @endforeach

        <tr>
    <td colspan="7" style="text-align: left; font-weight: bold;">
        Total des heures effectuées :
        {{ $totalH }} hr {{ str_pad($totalM, 2, '0', STR_PAD_LEFT) }} min
    </td>
</tr>

      </tbody>
    </table>

    <br />
    <p class="text-center">Thank your for working with Inspire Academy</p>
  </body>
</html>
