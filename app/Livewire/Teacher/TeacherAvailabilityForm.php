<?php

namespace App\Livewire\Teacher;

use Livewire\Component;
use App\Models\TeacherAvailability;
use Illuminate\Support\Facades\Auth;

class TeacherAvailabilityForm extends Component
{
    public string $date = '';
    public string $start_time = '';
    public string $end_time = '';

    protected function rules(): array
    {
        return [
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ];
    }

    public function save()
    {
        $this->validate();

        TeacherAvailability::create([
            'user_id' => Auth::id(),
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        $this->reset(['date', 'start_time', 'end_time']);

        session()->flash('success', 'Disponibilité ajoutée.');
    }

    public function delete(int $id)
    {
        TeacherAvailability::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
    }

    public function render()
    {
        return view('livewire.Teacher.teacher-availability-form', [
            'availabilities' => TeacherAvailability::where('user_id', Auth::id())
                ->orderBy('date')
                ->orderBy('start_time')
                ->get(),
        ]);
    }
}
