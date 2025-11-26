<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Language;

class OnlineCoursesLanguages extends Component
{
    public $languages;
    public $name;
    public $description;

    public function mount()
    {
        $this->loadLanguages();
    }

    public function loadLanguages()
    {
        $this->languages = Language::orderBy('name')->get();
    }

    public function addLanguage()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:languages,name',
            'description' => 'nullable|string|max:255',
        ]);

        Language::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description']);
        $this->loadLanguages();
    }

    public function deleteLanguage($id)
    {
        $language = Language::find($id);
        if ($language) {
            $language->delete();
            $this->loadLanguages();
        }
    }

    public function render()
    {
        return view('livewire.admin.online-courses-languages')
            ->layout('components.layouts.plain', ['title' => 'Gestion des langues']);
    }
}
