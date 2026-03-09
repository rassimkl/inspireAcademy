<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CourseStudent;
use App\Models\Course;
use App\Models\ClassSession;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendFollowupEmails extends Command
{
    protected $signature = 'followup:send';
    protected $description = 'Send follow-up email when student reaches 50% of hours';

    public function handle()
    {
        // On récupère chaque étudiant concerné
        $students = CourseStudent::select('student_id')
            ->groupBy('student_id')
            ->get();

        foreach ($students as $studentRecord) {

            $studentId = $studentRecord->student_id;
            $student = User::find($studentId);

            if (!$student) {
                continue;
            }

            // Récupère tous les segments de la formation de cet étudiant
            $courseLinks = CourseStudent::where('student_id', $studentId)->get();


            // Total des heures prévues (somme des total_hours de chaque segment)
            $totalHours = Course::whereIn('id', $courseLinks->pluck('course_id'))
                ->sum('total_hours');

            // Total des heures effectuées (sum des classes.hours)
            $doneHours = ClassSession::whereIn('course_id', $courseLinks->pluck('course_id'))
                ->sum('hours');
        

            if ($totalHours == 0) {
                continue;
            }

            // Pourcentage réalisé
            $progress = ($doneHours / $totalHours) * 100;

            // Si étudiant dépasse 50 % → envoyer un mail
            if ($progress >= 50 && $courseLinks->contains('followup_sent', false)) {

                // Envoi du mail
                // Mail::to($student->email)->send(new \App\Mail\FollowupMail($student, $progress));
                // Mail de notification pour l’école
                Mail::to('contact@inspireacademy.fr')->send(new \App\Mail\AdminFollowupNotificationMail($student, $progress));
                // On met followup_sent = true sur TOUTES ses lignes
                CourseStudent::where('student_id', $studentId)
                    ->update(['followup_sent' => true]);

                $this->info("Notification admin envoyée pour l'étudiant {$student->email}");
            }

               /* =========================================================================
                📌 PARTIE 2 — Mail fin de formation (100%)
               =========================================================================*/

            if ($progress >= 100 && $courseLinks->contains('finished_sent', false)) {

                // Mail::to($student->email)->send(new \App\Mail\FinishedCourseMail($student, $progress));

                Mail::to('contact@inspireacademy.fr')->send(new \App\Mail\FinishedCourseAdminNotification($student, $progress));

                // Marquer comme envoyé
                CourseStudent::where('student_id', $studentId)
                    ->update(['finished_sent' => true]);

                $this->info("Notification admin envoyée pour la fin de formation de l'étudiant {$student->email}");
            }


        }

        return Command::SUCCESS;
    }
}
