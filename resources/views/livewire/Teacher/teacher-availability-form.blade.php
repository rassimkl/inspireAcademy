<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Mes disponibilités</h2>
                <p class="text-muted mb-0">
                    Indiquez vos créneaux de disponibilité
                </p>
            </div>
        </div>

        {{-- FORMULAIRE --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                Ajouter une disponibilité
            </div>

            <div class="card-body row g-3">

                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" wire:model="date">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Heure début</label>
                    <input type="time" class="form-control" wire:model="start_time">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Heure fin</label>
                    <input type="time" class="form-control" wire:model="end_time">
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" wire:click="save">
                        Ajouter la disponibilité
                    </button>
                </div>

            </div>
        </div>

        {{-- LISTE --}}
        <div class="card">
            <div class="card-header fw-semibold">
                Mes disponibilités enregistrées
            </div>

            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availabilities as $a)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                                <td>{{ $a->start_time }}</td>
                                <td>{{ $a->end_time }}</td>
                                <td class="text-end">
                                    <button
                                        class="btn btn-sm btn-danger"
                                        wire:click="delete({{ $a->id }})"
                                    >
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Aucune disponibilité enregistrée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
