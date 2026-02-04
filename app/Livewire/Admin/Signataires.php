<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Signataire;

class Signataires extends Component
{
    public string $nom = '';
    public string $role = '';
    public bool $actif = true;

    public ?int $editingId = null;

    protected function rules()
    {
        return [
            'nom' => 'required|string|min:3',
            'role' => 'required|string|min:3',
            'actif' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        Signataire::updateOrCreate(
            ['id' => $this->editingId],
            [
                'nom' => $this->nom,
                'role' => $this->role,
                'actif' => $this->actif,
            ]
        );

        $this->resetForm();
    }

    public function edit(Signataire $signataire)
    {
        $this->editingId = $signataire->id;
        $this->nom = $signataire->nom;
        $this->role = $signataire->role;
        $this->actif = $signataire->actif;
    }

    public function delete(Signataire $signataire)
    {
        $signataire->delete();
    }

    public function resetForm()
    {
        $this->reset(['nom', 'role', 'actif', 'editingId']);
        $this->actif = true;
    }

    public function getSignatairesProperty()
    {
        return Signataire::orderBy('nom')->get();
    }

    public function render()
    {
        return view('livewire.admin.signataires');
    }
}
