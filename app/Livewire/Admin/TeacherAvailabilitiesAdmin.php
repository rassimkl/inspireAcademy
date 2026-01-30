<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TeacherAvailability;

class TeacherAvailabilitiesAdmin extends Component
{
    public string $language = '';
    public ?string $date = null;
    public ?string $hour = null;
    public ?int $month = null;
    public ?int $year = null;

    public function mount()
{
    $this->year = now()->year;
}

    public array $languages = [
        'Spanish',
        'English',
        'French',
        'Italian',
        'German',
        'Arabic',
        'Portuguese',
        'Basque',
        'Russian',
    ];

    public function render()
    {
        $availabilities = TeacherAvailability::query()

    // 🟡 PRIORITÉ 1 : date précise
    ->when($this->date, function ($q) {
        $q->whereDate('date', $this->date);
    })

    // 🟡 PRIORITÉ 2 : mois + année (uniquement si PAS de date)
    ->when(!$this->date && $this->month, function ($q) {
        $q->whereMonth('date', $this->month)
          ->whereYear('date', $this->year);
    })

    // ⏰ heure
    ->when($this->hour, function ($q) {
        $q->where('start_time', '<=', $this->hour)
          ->where('end_time', '>=', $this->hour);
    })

    // 🌍 langue depuis users.languages (JSON)
    ->when($this->language, function ($q) {
        $q->whereHas('teacher', function ($t) {
            $t->whereJsonContains('languages', $this->language);
        });
    })

    ->with('teacher')
    ->orderBy('date')
    ->orderBy('start_time')
    ->get();

        return view('livewire.admin.teacher-availabilities-admin', [
            'availabilities' => $availabilities,
        ]);
    }
}
