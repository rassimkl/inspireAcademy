<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\Payment; // Assuming Payment model is used

class PDFController extends Controller
{
    public function downloadPdf($paymentId)
    {
        // Fetch data from the database
        $payment = Payment::findOrFail($paymentId); // Adjust this as needed

        // Load the view with the data
        $data = ['payment' => $payment, 'user' => $payment->user];
        $view = view('invoice.invoice', $data)->render();

        // Create a new DOMPDF instance
        $pdf = new Dompdf();

        // Load HTML content into DOMPDF
        $pdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important to call this before outputting PDF content)
        $pdf->render();

        // Output PDF to the browser
        return $pdf->stream('invoice.pdf');

        //return view('invoice.invoice', $data);
    }
}
