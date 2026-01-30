<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">My Availability</h2>
                <p class="text-muted mb-0">
                    Your available time slots
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">
                Add Availability
            </div>

            <div class="card-body row g-3">

                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" class="form-control" wire:model="date">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" wire:model="start_time">
                </div>

                <div class="col-md-3">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" wire:model="end_time">
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" wire:click="save">
                        Add Availability
                    </button>
                </div>

            </div>
        </div>

        {{-- LIST --}}
        <div class="card">
            <div class="card-header fw-semibold">
                My Availability (by date)
            </div>

            <div class="card-body">

                @php
                    $grouped = $availabilities->groupBy('date');
                @endphp

                @if($grouped->isEmpty())
                    <div class="text-center text-muted py-4">
                        No availability recorded
                    </div>
                @else
                    <div class="accordion" id="availabilityAccordion">

                        @foreach($grouped as $date => $items)
                            @php
                                $collapseId = 'date-'.$loop->index;
                            @endphp

                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button collapsed fw-semibold"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                    >
                                        📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F Y') }}
                                        <span class="badge bg-secondary ms-2">
                                            {{ $items->count() }} slot(s)
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="{{ $collapseId }}"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#availabilityAccordion"
                                >
                                    <div class="accordion-body p-0">

                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $a)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-success">
                                                                {{ \Carbon\Carbon::parse($a->start_time)->format('H:i') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-danger">
                                                                {{ \Carbon\Carbon::parse($a->end_time)->format('H:i') }}
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            <button
                                                                class="btn btn-sm btn-outline-danger"
                                                                wire:click="delete({{ $a->id }})"
                                                            >
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
