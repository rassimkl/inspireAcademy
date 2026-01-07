<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FichePresenceGlobal extends Component
{
    public int $year = 2025;

    public function mount()
    {
        // Sécurité : admin uniquement
        if (Auth::user()->user_type_id !== 1) {
            abort(403);
        }
    }

    public function downloadZip()
    {
        $zipPath = storage_path("app/fiches_presence_{$this->year}.zip");
    $zip = new \ZipArchive();
    $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    // Tous les enseignants
    $teachers = \App\Models\User::where('user_type_id', 2)->get();

    foreach ($teachers as $teacher) {

        $teacherFolder = "Enseignant_{$teacher->last_name}_{$teacher->first_name}";

        foreach ($teacher->coursesAsTeacher as $course) {

            // Boucle sur les 12 mois
            for ($month = 1; $month <= 12; $month++) {

                $classes = $course->classes()
                    ->whereYear('date', $this->year)
                    ->whereMonth('date', $month)
                    ->get();

                // S’il n’y a aucune classe ce mois → on passe
                if ($classes->isEmpty()) {
                    continue;
                }

                // Nom du dossier du mois (ex : 01_Janvier)
                $monthName = \Carbon\Carbon::create()->month($month)->translatedFormat('m_F');

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('fiche.fiche', [
                    'course'   => $course,
                    'classes'  => $classes,
                    'students' => $course->students,
                    'teacher'  => $teacher,
                    'date' => str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . $this->year,
                ]);

                $fileName = "{$teacherFolder}/{$monthName}/{$course->name}.pdf";

                $zip->addFromString($fileName, $pdf->output());
            }
        }
    }

    $zip->close();

    return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.admin.fiche-presence-global');
    }
}
