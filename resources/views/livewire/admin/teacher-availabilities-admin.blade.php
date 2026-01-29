<div class="page-wrapper">
    <div class="content container-fluid">

        <h2 class="fw-bold mb-4">Disponibilités des enseignants</h2>

        <div class="card mb-4">
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label">Langue</label>
                    <select class="form-select" wire:model.live="language">
                        <option value="">Toutes</option>
                        @foreach($languages as $l)
                            <option value="{{ $l }}">{{ $l }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Mois</label>
                    <select class="form-select" wire:model.live="month">
                        <option value="">—</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Année</label>
                    <select class="form-select" wire:model.live="year">
                        @for($y = now()->year - 1; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" wire:model.live="date">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Heure</label>
                    <input type="time" class="form-control" wire:model.live="hour">
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header fw-semibold">Résultat</div>
            <div class="card-body p-0">

                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Prof</th>
                            <th>Date</th>
                            <th>Début</th>
                            <th>Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availabilities as $a)
                            <tr>
                                <td>{{ $a->teacher->first_name }} {{ $a->teacher->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                                <td>{{ $a->start_time }}</td>
                                <td>{{ $a->end_time }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucune disponibilité trouvée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
