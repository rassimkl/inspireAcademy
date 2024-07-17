<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Facture</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
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
        table, th, td {
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

    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">Inspire Academy</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    
             <span>Date: {{ now()->format('Y-m-d') }}</span> <br>


                    <span>Code postal : 64200</span> <br>
                    <span>Address: 25 All. du Moura, Biarritz</span> <br>
                         <span>Phone : 05 54 00 75 5 12</span> 
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Détails</th>
                <th width="50%" colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td>Email :</td>
                <td>{{$user->email}}</td>

                <td>Nom et prénom:</td>
                <td>{{$user->last_name}} {{$user->first_name}}</td>
            </tr>
            <tr>
                <td>Date</td>
                <td>{{$date}}<br></td>

                <td>Phone:</td>
                <td>{{$user->phone_number}}</td>
              
            </tr>
           
             <tr>
                <td>Siret</td>
                <td>{{$user->siret}}<br></td>

                <td>TITULAIRE:</td>
                <td>{{$user->name_on_bank}}<br></td>
            </tr>
             <tr>
                <td>Bic/Swift:</td>
                <td>{{$user->bic}}<br></td>

                <td>IBAN:</td>
                <td>{{$user->iban}}</td>
            </tr>
         
     
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                   Paiements
                </th>
            </tr>
            <tr class="bg-blue">
                <th>Formations</th>
                <th></th>
                <th>Heures</th>
                <th>prix par heure €</th>
                <th>Total €</th>
            </tr>
        </thead>
        <tbody>
@php
$total=0;
@endphp
          @foreach ($courses as $courseId => $hours)
            @php
                $course = App\Models\Course::find($courseId);
                $total+=$hours*$course->charge_per_hour; // Adjust your Course model namespace
            @endphp
            <tr>
                <td width="30%">{{$course->name}}</td>
                <td>
                  
                </td>
                <td width="10%">{{$hours}}</td>
                <td width="15%">{{ $course->charge_per_hour}}</td>
                <td width="15%" class="fw-bold">€ {{ $course->charge_per_hour*$hours}}</td>
            </tr>
           @if($loop->last)
            <tr>
                <td colspan="4" class="total-heading">Montant Total :</td>
                <td colspan="1" class="total-heading">€ {{$total}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>

    <br>
    <p class="text-center">
       Merci de travailler avec Inspire Academy
    </p>

</body>
</html>