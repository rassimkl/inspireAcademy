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
use App\Livewire\AdminList;
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
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Admin\OnlineCoursesLanguages;
use App\Livewire\Admin\OnlineCoursesLanguageShow;
use App\Livewire\Teacher\OnlineCourses;
use App\Livewire\Admin\FichePresenceGlobal;
use App\Livewire\Admin\InvoiceGlobal;
use App\Livewire\Admin\CompanyDocs;
use App\Livewire\Admin\OnboardingMailForm;
use App\Livewire\Teacher\TeacherAvailabilityForm;
use App\Livewire\Admin\TeacherAvailabilitiesAdmin;
use App\Livewire\Admin\EndOfTrainingMailForm;
use App\Livewire\Admin\Signataires;




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


    Route::get('/teacher/Fiche', FichePresence::class)->name('teacher/fiche');
    Route::get('/download-fichpdf/{course}/{date}', [PDFController::class, 'downloadPdfich'])->name('downloadfich.pdf');
    Route::get('/courses/addclass', AddClass::class)->name('courses/addclass');

    Route::get('/my/payments/', MyPayments::class)->name('my/payments');
    Route::get('/download-asteacher-invoice-pdf/{teacherId}/{date}', [PDFController::class, 'downloadInvoiceAsTeacherPdf'])->name('download.invoice.t.pdf');


    Route::get('/teacher/courses', OnlineCourses::class)->name('teacher.OnlineCourses');



});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/home', Home::class)->name('home');
    Route::get('user/add/page', AddUser::class)->name('user/add/page'); // page student

    Route::get('/student/list', Students::class)->name('student/list');
    Route::get('/teacher/list', Teachers::class)->name('teacher/list');
    Route::get('/intern/list', Interns::class)->name('intern/list');
    Route::get('/admin/list', AdminList::class)->name('admin/list');
    Route::get('/users/edit/{userId}', EditUser::class)->name('user/edit');
    Route::get('/courses/create', CreateCourse::class)->name('courses.create');

    Route::get('/teacher/payments/', ManageTeacherPayments::class)->name('teacher/payments');
    Route::get('/teacher/payments/history', PaymentHistory::class)->name('teacher/payments/history');

    Route::get('/courses/{course}/edit', EditCourse::class)->name('courses/edit');
    Route::get('/teachers/all/payments', ViewPayments::class)->name('teacher/all/payments');
    Route::get('/download-pdf/{payment}', [PDFController::class, 'downloadPdf'])->name('download.pdf');
    Route::get('/download-invoice-pdf/{teacherId}/{date}', [PDFController::class, 'downloadInvoicePdf'])->name('download.invoice.pdf');

    Route::get('/online-courses', OnlineCoursesLanguages::class)->name('online_courses.index');
    Route::get('/online-courses/{language}', OnlineCoursesLanguageShow::class)->name('online_courses.show');
    
    Route::get('/admin/fiche-presence/export', FichePresenceGlobal::class)
    ->name('admin.fiche.presence.export');

    Route::get('/admin/factures/export', InvoiceGlobal::class)
    ->name('admin.invoices.export');

    Route::get('/admin/docs-entreprise', CompanyDocs::class)
    ->name('admin.company.docs');

    Route::get('/admin/onboarding-mail', OnboardingMailForm::class)
    ->name('admin.onboarding-mail');

    Route::get('/admin/teacher-availabilities', TeacherAvailabilitiesAdmin::class)
    ->name('admin.teacher.availabilities');

    Route::get('/admin/fin-formation', EndOfTrainingMailForm::class)
    ->name('admin.fin-formation');

    
    Route::get('/admin/signataires', Signataires::class)
    ->name('admin.signataires');

});
Route::middleware(['adminteacher'])->group(function () {
    Route::get('/teacher/classes/', ClassList::class)->name('teacher/classes');

    Route::get('/view-class/{classId}', ViewClass::class)->name('class/details');

    Route::get('/user/profile/{user}', UserDetails::class)->name('user/details');
    Route::get('/edit/class/{classsession}', EditClassSession::class)->name('class/edit');
    Route::get('/submit/class/{classsession}', SubmitClass::class)->name('class/submit');

    Route::get('/teacher/availabilities', TeacherAvailabilityForm::class)
    ->name('teacher.availabilities');
    



});
Route::middleware(['teacherstudentadmin'])->group(function () {
    Route::get('/student', Student::class)->name('student/home');
    Route::get('/course/list', Courses::class)->name('course/list');
    Route::get('/course/details/{course}', CourseDetails::class)->name('course/deails');
    Route::get('/student/courses', \App\Livewire\Student\Courses::class)->name('student.courses');

});


if (!function_exists('set_active')) {
function set_active($route)
{
    if (is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

}




