<div class="page-wrapper">
    <div class="content container-fluid">

        <h2 class="fw-bold mb-4">Teachers Availability</h2>

        <div class="card mb-4">
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label">Language</label>
                    <select class="form-select" wire:model.live="language">
                        <option value="">All</option>
                        @foreach($languages as $l)
                            <option value="{{ $l }}">{{ $l }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Month</label>
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
                    <label class="form-label">Year</label>
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
                    <label class="form-label">Time</label>
                    <input type="time" class="form-control" wire:model.live="hour">
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header fw-semibold">
                Available Teachers
            </div>

            <div class="card-body">

                @php
                    $grouped = $availabilities->groupBy('user_id');
                @endphp

                @if($grouped->isEmpty())
                    <div class="text-center text-muted py-4">
                        No availability found
                    </div>
                @else
                    <div class="accordion" id="teachersAccordion">

                        @foreach($grouped as $teacherId => $items)
                            @php
                                $teacher = $items->first()->teacher;
                                $collapseId = 'teacher-'.$teacherId;
                            @endphp

                            <div class="accordion-item mb-2">
                                <h2 class="accordion-header" id="heading-{{ $teacherId }}">
                                    <button
                                        class="accordion-button collapsed fw-semibold"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                    >
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        <span class="badge bg-secondary ms-2">
                                            {{ $items->count() }} slot(s)
                                        </span>
                                    </button>
                                </h2>

                                <div
                                    id="{{ $collapseId }}"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#teachersAccordion"
                                >
                                    <div class="accordion-body p-0">

                                        <table class="table table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $a)
                                                    <tr>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}
                                                        </td>
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
