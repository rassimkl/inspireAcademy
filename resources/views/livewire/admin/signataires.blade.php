<div class="page-wrapper">
    <div class="content container-fluid">

        <h2 class="fw-bold mb-4">✍️ Gestion des signataires</h2>

        {{-- FORMULAIRE --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                {{ $editingId ? 'Modifier un signataire' : 'Ajouter un signataire' }}
            </div>

            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nom</label>
                    <input class="form-control" wire:model="nom">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Rôle</label>
                    <input class="form-control" wire:model="role">
                </div>

                <div class="col-md-2 d-flex align-items-center">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" wire:model="actif">
                        <label class="form-check-label">Actif</label>
                    </div>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100" wire:click="save">
                        {{ $editingId ? 'Mettre à jour' : 'Ajouter' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- LISTE --}}
        <div class="card">
            <div class="card-header fw-semibold">Liste des signataires</div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Rôle</th>
                            <th>Actif</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->signataires as $signataire)
                            <tr>
                                <td>{{ $signataire->nom }}</td>
                                <td>{{ $signataire->role }}</td>
                                <td>
                                    @if($signataire->actif)
                                        <span class="badge bg-success">Oui</span>
                                    @else
                                        <span class="badge bg-secondary">Non</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                            wire:click="edit({{ $signataire->id }})">
                                        Modifier
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                            wire:click="delete({{ $signataire->id }})">
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
