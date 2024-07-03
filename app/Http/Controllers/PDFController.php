<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


    public function downloadPdfich($courseid, $date)
    {

        $user = Auth::user();


        $classesQuery = $user->classes()->with('course')->orderBy('date', 'desc');
        $classesQuery->where('course_id', $courseid);
        // Check the value of $status and apply appropriate filtering

        // Parse the selected month and year from the date string
        if ($date) {
            list($month, $year) = explode('-', $date);

            // Add condition to filter by selected month and year
            $classesQuery->whereYear('date', '=', $year)
                ->whereMonth('date', '=', $month);
        }

        $classes = $classesQuery->get();

        foreach ($classes as $class) {
            if ($class->status == 1) {
                $this->addError('course', 'Please Submit all classes');
                return; // Exit the method to prevent further execution
            }
        }

        $course = Course::findOrFail($courseid);
        $students = $course->students;

        // Load the view with the data
        $data = ['course' => $course, 'teacher' => $user, 'students' => $students, 'classes' => $classes, 'date' => $date];


        $view = view('fiche.fiche', $data);

        // Create a new DOMPDF instance
        $pdf = new Dompdf();


        // Load HTML content into DOMPDF
        $pdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important to call this before outputting PDF content)
        $pdf->render();

        // Output PDF to the browser
        return $pdf->stream('fiche.pdf');

        //return view('invoice.invoice', $data);
    }
}
