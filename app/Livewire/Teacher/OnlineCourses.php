<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Language;
use App\Models\Level;
use App\Models\OnlineCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OnlineCourses extends Component
{
    use WithFileUploads;

    public $teacher;
    public $languages = [];
    public $languageSelected = null;
    public $levels = [];
    public $courses = [];

    public $title;
    public $level;
    public $file;

    public function mount()
    {
        $this->teacher = Auth::user();

        // 🧩 Récupère les langues depuis la colonne JSON "languages" du user
        $langs = json_decode($this->teacher->languages, true) ?? [];
        $this->languages = Language::whereIn('name', $langs)->orderBy('name')->get();

        if ($this->languages->isNotEmpty()) {
            $this->languageSelected = $this->languages->first()->id;
        }

        $this->levels = Level::orderBy('id')->get();

        $this->loadCourses();
    }

    public function changeLanguage()
    {
        $this->languageSelected = (int) $this->languageSelected;
        $this->loadCourses();
    }

    public function loadCourses()
    {
        if (!$this->languageSelected) {
            $this->courses = collect();
            return;
        }

        // 🔹 Cours ajoutés uniquement par cet enseignant
        $this->courses = OnlineCourse::where('language_id', $this->languageSelected)
            ->where('created_by', $this->teacher->id)
            ->get();
    }

public function save()
{
    // ✅ Validation des champs avant enregistrement
    $this->validate([
        'title' => 'required|string|max:255',
        'level' => 'required',
        'file'  => 'required|mimes:pdf|max:5120', // Taille max = 5 MB
    ]);

    // ⚠️ Vérifie qu'une langue est bien sélectionnée
    if (!$this->languageSelected) {
        session()->flash('error', 'Please select a language before adding a course.');
        return;
    }

    // ✅ Vérifie que la langue choisie appartient bien à l’enseignant
    $teacherLangs = json_decode($this->teacher->languages, true) ?? [];
    $language = Language::find($this->languageSelected);

    if (!$language || !in_array($language->name, $teacherLangs)) {
        session()->flash('error', 'You cannot add a course for this language.');
        return;
    }

    // ✅ Enregistre le fichier PDF dans le storage
    $path = $this->file->store('onlineCourses', 'public');

    // ✅ Crée le nouveau cours
    OnlineCourse::create([
        'language_id' => $this->languageSelected,   // langue choisie
        'title'       => $this->title,
        'level_id'    => $this->level,
        'file_path'   => $path,
        'created_by'  => $this->teacher->id,        // enseignant connecté
    ]);

    // ✅ Réinitialise les champs du formulaire
    $this->reset(['title', 'level', 'file']);

    // ✅ Recharge la liste mise à jour
    $this->loadCourses();

    // ✅ Message visuel de confirmation
    session()->flash('success', 'Course added successfully 🎉');

    // ✅ Reset du champ fichier côté front
    $this->dispatch('reset-file-input');
}


    // ============================================================
    // 🗑️ SUPPRIMER UN COURS EXISTANT
    // ============================================================
    public function delete($id)
    {
        // 1️⃣ Récupérer le cours correspondant
        $course = OnlineCourse::find($id);

        // 2️⃣ Supprimer le fichier PDF du disque si présent
        if (Storage::disk('public')->exists($course->file_path)) {
            Storage::disk('public')->delete($course->file_path);
        }

        // 3️⃣ Supprimer l’entrée du cours dans la base de données
        if ($course) {
            $course->delete();
            session()->flash('success', 'Cours deleted 🗑');
        }

        // 4️⃣ Recharger la liste actualisée des cours
        $this->loadCourses();
    }

    public function render()
    {
        return view('livewire.Teacher.online-courses')
            ->layout('components.layouts.plain', ['title' => 'My Courses']);
    }
}
