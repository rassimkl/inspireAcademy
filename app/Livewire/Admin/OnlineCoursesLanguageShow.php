<?php

namespace App\Livewire\Admin;

// ============================================================
// 🧩 IMPORTS DES DÉPENDANCES
// ============================================================
use Livewire\Component;                     // Base Livewire component
use Livewire\WithFileUploads;               // Pour gérer les fichiers uploadés
use App\Models\OnlineCourse;                // Modèle des cours en ligne
use App\Models\Language;                    // Modèle des langues
use Illuminate\Support\Facades\Storage;     // Pour gérer les fichiers dans le storage


class OnlineCoursesLanguageShow extends Component
{
    // ============================================================
    // 🔹 TRAIT POUR LES UPLOADS
    // ============================================================
    use WithFileUploads;

    // ============================================================
    // 🔸 PROPRIÉTÉS PUBLIQUES DISPONIBLES POUR LE FRONT (Livewire)
    // ============================================================
    public $language;     // Langue actuelle (objet Language)
    public $courses;      // Liste des cours associés à la langue
    public $title;        // Titre du cours à ajouter
    public $level;        // Niveau du cours (ex: A1, B2, etc.)
    public $file;         // Fichier PDF uploadé
    public $levels = [];  // Liste de tous les niveaux disponibles (A1, A2, B1...)


    // ============================================================
    // 🏁 MONTAGE INITIAL DU COMPOSANT (AU CHARGEMENT DE LA PAGE)
    // ============================================================
    public function mount($language)
    {
        // 1️⃣ Charger tous les niveaux (A1, A2, B1, etc.)
        $this->levels = \App\Models\Level::all();

        // 2️⃣ Récupérer la langue (ex: English, Arabic...) passée en paramètre
        $this->language = Language::findOrFail($language);

        // 3️⃣ Charger tous les cours liés à cette langue
        $this->loadCourses();
    }


    // ============================================================
    // 🔁 CHARGER LA LISTE DES COURS PAR LANGUE
    // ============================================================
    public function loadCourses()
    {
        $this->courses = OnlineCourse::where('language_id', $this->language->id)->get();
    }


    // ============================================================
    // 💾 ENREGISTRER UN NOUVEAU COURS (TITRE + PDF)
    // ============================================================
    public function save()
    {
        // 🔸 Validation des champs avant enregistrement
        $this->validate([
            'title' => 'required|string|max:255',
            'level' => 'required',
            'file'  => 'required|mimes:pdf|max:5120', // Taille max = 5 MB
        ]);

        // 🔸 Enregistrement du fichier dans le dossier storage/app/public/onlineCourses
        $path = $this->file->store('onlineCourses', 'public');

        // 🔸 Création d’un nouveau cours dans la base de données
        OnlineCourse::create([
            'language_id' => $this->language->id,
            'title'       => $this->title,
            'level_id'    => $this->level,
            'file_path'   => $path,
            'created_by'  => auth()->id(),
        ]);

        // 🔸 Réinitialiser les champs du formulaire
        $this->reset(['title', 'level', 'file']);

        // 🔸 Recharger la liste mise à jour des cours
        $this->loadCourses();

        // 🔸 Message de confirmation visuel
        session()->flash('success', 'Cours added 🎉');

        // 🔸 Événement JS (Livewire → Frontend)
        //     → pour réinitialiser le champ fichier dans la vue
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


    // ============================================================
    // 🎨 RENDU DE LA VUE (LIEN AVEC LE FICHIER BLADE)
    // ============================================================
    public function render()
    {
        return view('livewire.admin.online-courses-language-show')
            ->layout('components.layouts.plain');
    }
}
