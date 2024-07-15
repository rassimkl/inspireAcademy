<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Course;
use App\Models\ClassSession;
use Illuminate\Support\MessageBag;
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
        $pdf->stream('invoice.pdf');
        exit();
        //return view('invoice.invoice', $data);
    }


    public function downloadPdfich($courseid, $date)
    {

        $user = Auth::user();

        $course = Course::findOrFail($courseid);
        if (!$courseid || $course->teacher_id != $user->id) {
            $errors = new MessageBag;
            $errors->add('course', 'Please select a course first');
            return redirect('/teacher/Fiche')->withErrors($errors);
        }
        $classesQuery = $user->classes()->with('course')->orderBy('date', 'asc');
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
                $errors = new MessageBag;
                $errors->add('course', 'Please submit all classes before generating Fiche');
                return redirect('/teacher/Fiche')->withErrors($errors);

            }
        }


        $students = $course->students;

        // Load the view with the data
        $data = ['course' => $course, 'teacher' => $user, 'students' => $students, 'classes' => $classes, 'date' => $date];


        $view = view('fiche.fiche', $data)->render();
        ;

        // Create a new DOMPDF instance
        $pdf = new Dompdf();


        // Load HTML content into DOMPDF
        $pdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important to call this before outputting PDF content)
        $pdf->render();

        // Output PDF to the browser
        $pdf->stream('fiche.pdf');
        exit();
        //return view('invoice.invoice', $data);
    }


    public function downloadInvoicePdf($teacherId, $date)
    {
        list($month, $year) = explode('-', $date);

        $teacher = User::find($teacherId);

        $hasPaymentStatus1 = $teacher->classes()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('payment_status', 1)
            ->exists();
        // Check the result
        if ($hasPaymentStatus1) {

            $errors = new MessageBag;
            $errors->add('download', 'Please set all classes as paid before generating Invoice in Manage Payments section');
            return redirect()->route('teacher/payments/history')->withErrors($errors);

        }


        // Fetch data from the database

        $classes = ClassSession::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('payment_status', 2)
            ->get();

        $hoursByCourse = [];

        foreach ($classes as $lesson) {
            $courseId = $lesson->course_id;
            $hoursByCourse[$courseId] = ($hoursByCourse[$courseId] ?? 0) + $lesson->hours;
        }
        $teacher = User::find($teacherId);

        // Load the view with the data
        $data = ['user' => $teacher, 'courses' => $hoursByCourse, 'date' => $date];

        $view = view('invoice.facture', $data)->render();

        // Create a new DOMPDF instance
        $pdf = new Dompdf();

        // Load HTML content into DOMPDF
        $pdf->loadHtml($view);

        // (Optional) Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (important to call this before outputting PDF content)
        $pdf->render();

        // Output PDF to the browser
        $pdf->stream('invoice.pdf');
        exit();
        //return view('invoice.invoice', $data);
    }

}
