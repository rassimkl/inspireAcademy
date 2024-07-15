<?php

use App\Models\User;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\AddUser;
use App\Livewire\Courses;
use App\Livewire\Interns;
use App\Livewire\Student;
use App\Livewire\AddClass;
use App\Livewire\EditUser;
use App\Livewire\Students;
use App\Livewire\Teachers;
use App\Livewire\ClassList;
use App\Livewire\ViewClass;
use App\Livewire\EditCourse;
use App\Livewire\MyPayments;
use App\Livewire\SubmitClass;
use App\Livewire\TeacherHome;
use App\Livewire\UserDetails;
use App\Livewire\ClassSession;
use App\Livewire\CreateCourse;
use App\Livewire\ViewPayments;
use App\Livewire\CourseDetails;
use App\Livewire\FichePresence;
use App\Livewire\PaymentHistory;
use App\Livewire\EditClassSession;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDFController;
use App\Livewire\ManageTeacherPayments;
use App\Http\Controllers\Auth\LogoutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */




Route::get('/', Login::class)->name('login')->middleware('guest');







Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'teacher'])->group(function () {




    Route::get('/teacher/home', TeacherHome::class)->name('teacher/home');

    Route::get('/add/class/{course}', ClassSession::class)->name('class/add');
    Route::get('/edit/class/{classsession}', EditClassSession::class)->name('class/edit');
    Route::get('/submit/class/{classsession}', SubmitClass::class)->name('class/submit');

    Route::get('/teacher/Fiche', FichePresence::class)->name('teacher/fiche');
    Route::get('/download-fichpdf/{course}/{date}', [PDFController::class, 'downloadPdfich'])->name('downloadfich.pdf');
    Route::get('/courses/addclass', AddClass::class)->name('courses/addclass');

    Route::get('/my/payments/', MyPayments::class)->name('my/payments');



});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/home', Home::class)->name('home');
    Route::get('user/add/page', AddUser::class)->name('user/add/page'); // page student

    Route::get('/student/list', Students::class)->name('student/list');
    Route::get('/teacher/list', Teachers::class)->name('teacher/list');
    Route::get('/intern/list', Interns::class)->name('intern/list');
    Route::get('/users/edit/{userId}', EditUser::class)->name('user/edit');
    Route::get('/courses/create', CreateCourse::class)->name('courses.create');

    Route::get('/teacher/payments/', ManageTeacherPayments::class)->name('teacher/payments');
    Route::get('/teacher/payments/history', PaymentHistory::class)->name('teacher/payments/history');
    
    Route::get('/courses/{course}/edit', EditCourse::class)->name('courses/edit');
    Route::get('/teachers/all/payments', ViewPayments::class)->name('teacher/all/payments');
    Route::get('/download-pdf/{payment}', [PDFController::class, 'downloadPdf'])->name('download.pdf');
    Route::get('/download-invoice-pdf/{teacherId}/{date}', [PDFController::class, 'downloadInvoicePdf'])->name('download.invoice.pdf');





});
Route::middleware(['adminteacher'])->group(function () {
    Route::get('/teacher/classes/', ClassList::class)->name('teacher/classes');

    Route::get('/view-class/{classId}', ViewClass::class)->name('class/details');

    Route::get('/user/profile/{user}', UserDetails::class)->name('user/details');

});
Route::middleware(['teacherstudentadmin'])->group(function () {
    Route::get('/student', Student::class)->name('student/home');
    Route::get('/course/list', Courses::class)->name('course/list');
    Route::get('/course/details/{course}', CourseDetails::class)->name('course/deails');

});


function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}






