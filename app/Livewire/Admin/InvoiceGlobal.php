<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceGlobal extends Component
{
    public int $year;
    public array $years = [];

    public function mount()
    {
        // Sécurité : admin uniquement
        if (Auth::user()->user_type_id !== 1) {
            abort(403);
        }
        $currentYear = Carbon::now()->year;

        // Exemple : de 2020 jusqu'à l'année en cours
        $this->years = range(2025, $currentYear);

        // Année sélectionnée par défaut = année en cours
        $this->year = $currentYear;
    }

    public function downloadZip()
    {
        $zipPath = storage_path("app/factures_{$this->year}.zip");

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Tous les enseignants
        $teachers = User::where('user_type_id', 2)->get();

        foreach ($teachers as $teacher) {

            $teacherFolder = "Enseignant_{$teacher->last_name}_{$teacher->first_name}";

            // Boucle sur les 12 mois
            for ($month = 1; $month <= 12; $month++) {

                // Récupérer toutes les séances du mois (tous cours confondus)
                $classes = $teacher->classes()
                    ->whereYear('date', $this->year)
                    ->whereMonth('date', $month)
                    ->get();

                // Aucun cours → pas de facture
                if ($classes->isEmpty()) {
                    continue;
                }

                // Regrouper les heures par cours
                $hoursByCourse = [];
                foreach ($classes as $lesson) {
                    $hoursByCourse[$lesson->course_id] =
                        ($hoursByCourse[$lesson->course_id] ?? 0) + $lesson->hours;
                }

                // Nom du dossier du mois (ex : 01_Janvier)
                $monthName = Carbon::create($this->year, $month, 1)
                    ->translatedFormat('m_F');

                // Génération du PDF de facture
                $pdf = Pdf::loadView('invoice.facture', [
                    'user'    => $teacher,
                    'courses' => $hoursByCourse,
                    'date'    => str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . $this->year,
                ]);

                $fileName = "{$teacherFolder}/{$monthName}/facture.pdf";
                $zip->addFromString($fileName, $pdf->output());
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.admin.invoice-global');
    }
}
