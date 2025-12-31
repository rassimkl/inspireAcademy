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

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Tous les enseignants
        $teachers = User::where('user_type_id', 2)->get();

        foreach ($teachers as $teacher) {

            $teacherFolder = "Enseignant_{$teacher->last_name}_{$teacher->first_name}";

            foreach ($teacher->coursesAsTeacher as $course) {

                $classes = $course->classes()
                    ->whereYear('date', $this->year)
                    ->get();

                // Pas de fiche si aucune classe en 2025
                if ($classes->isEmpty()) {
                    continue;
                }

                // Génération PDF avec TON TEMPLATE
                $pdf = Pdf::loadView('fiche.fiche', [
                    'course'   => $course,
                    'classes'  => $classes,
                    'students' => $course->students,
                    'teacher'  => $teacher,
                    'date'     => $this->year,
                ]);

                $fileName = "{$teacherFolder}/{$course->name}_{$this->year}.pdf";

                $zip->addFromString($fileName, $pdf->output());
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
