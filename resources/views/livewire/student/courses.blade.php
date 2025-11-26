<div class="container py-4">

    {{-- 🔹 En-tête --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold">📚 My Courses</h3>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>

    {{-- 🔍 Filtres --}}
    <div class="card shadow-sm p-3 mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Language</label>
                <select
                    class="form-select"
                    wire:model="languageSelected"
                    wire:change="changeLanguage"  {{-- ✅ déclenche explicitement le rechargement --}}
                >
                    @foreach($languages as $lang)
                        <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- 🕓 Message de chargement Livewire --}}
    <div wire:loading wire:target="languageSelected,changeLanguage" class="alert alert-info text-center">
        ⏳ Loading courses...
    </div>

    {{-- 🧾 Liste des cours --}}
    <div class="accordion" id="studentCoursesAccordion">
        @foreach($levels as $lvl)
            <div class="accordion-item shadow-sm mb-3 border-0" wire:key="level-{{ $lvl->id }}">
                <h2 class="accordion-header" id="heading-{{ $lvl->id }}">
                    <button class="accordion-button collapsed fw-semibold text-secondary" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse-{{ $lvl->id }}">
                        {{ $lvl->name }}
                    </button>
                </h2>

                <div id="collapse-{{ $lvl->id }}" class="accordion-collapse collapse">
                    <div class="accordion-body bg-light">
                        {{-- 🔹 Cours du niveau en cours --}}
                        @forelse($courses->where('level_id', $lvl->id) as $course)
                            <div class="d-flex justify-content-between align-items-center border p-2 mb-2 bg-white rounded shadow-sm">
                                <div>
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <strong>{{ $course->title }}</strong>
                                </div>
                                <div>
                                    <a href="{{ asset('files/'.$course->file_path) }}" target="_blank"
                                       class="btn btn-sm btn-outline-success me-2">
                                        <i class="fas fa-eye"></i> Open
                                    </a>
                                    <a href="{{ asset('files/'.$course->file_path) }}" download
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No courses for this level.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Aucun cours disponible --}}
        @if($courses->isEmpty())
            <p class="text-muted mt-3">No courses found for this language.</p>
        @endif
    </div>
</div>
