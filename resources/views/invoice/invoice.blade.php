<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #6</title>

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
                    <span>Invoice Id: PYT{{$payment->id}}</span> <br>
             <span>Date: {{ now()->format('Y-m-d') }}</span> <br>


                    <span>Zip code : 64200</span> <br>
                    <span>Address: 25 All. du Moura, Biarritz</span> <br>
                         <span>Phone : 05540075512</span> 
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Payment Details</th>
                <th width="50%" colspan="2">Teacher Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Payment Id:</td>
                <td>{{$payment->id}}</td>

                <td>Full Name:</td>
                <td>{{$user->first_name}} {{$user->last_name}}</td>
            </tr>
            <tr>
                <td>DATA</td>
                <td>No data</td>

                <td>Email Id:</td>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <td>Paid Date:</td>
                <td>{{ $payment->created_at->format('Y-m-d') }}<br></td>

                <td>Phone:</td>
                <td>{{$user->phone_number}}</td>
            </tr>
         
     
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                   Payments
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
                <th></th>
                <th>Price</th>
                <th>Hours</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="10%">{{$payment->id}}</td>
                <td>
                  
                </td>
                <td width="10%">€ {{$payment->amount}}</td>
                <td width="10%">{{$payment->hours}} Hours</td>
                <td width="15%" class="fw-bold">€ {{$payment->amount}}</td>
            </tr>
           
            <tr>
                <td colspan="4" class="total-heading">Total Amount - <small>Inc. all vat/tax</small> :</td>
                <td colspan="1" class="total-heading">€ {{$payment->amount}}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Thank your for working with Inspire Academy
    </p>

</body>
</html>