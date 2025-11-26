<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\OnlineCourse;
use App\Models\Language;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;

class Courses extends Component
{
    public $student;
    public $languages = [];
    public $languageSelected = null;
    public $levels = [];
    public $courses; // Collection

    public function mount()
    {
        $this->student = Auth::user();

        // 🧩 Récupère les langues du user (JSON de noms) -> mappe vers table languages
        $userLangs = json_decode($this->student->languages, true) ?? [];

        $this->languages = Language::whereIn('name', $userLangs)->orderBy('name')->get();

        // Langue par défaut
        if ($this->languages->isNotEmpty()) {
            $this->languageSelected = (int) $this->languages->first()->id;
        }

        // Tous les niveaux
        $this->levels = Level::orderBy('id')->get();

        // Charger initialement
        $this->loadCourses();
    }

    /** ✅ Appelé explicitement depuis le select (wire:change) */
    public function changeLanguage()
    {
        // Sécurise le type
        $this->languageSelected = (int) $this->languageSelected;

        $this->loadCourses();
    }

    /** 🔁 Requêtes cohérentes et filtrées */
    public function loadCourses()
    {
        $query = OnlineCourse::query();

        if (!empty($this->languageSelected)) {
            $query->where('language_id', (int) $this->languageSelected);
        } else {
            // Si pas de sélection valide, ne retourne rien
            $this->courses = collect();
            return;
        }

        $this->courses = $query->get();
    }

    public function render()
    {
        return view('livewire.student.courses')
            ->layout('components.layouts.plain');
    }
}
