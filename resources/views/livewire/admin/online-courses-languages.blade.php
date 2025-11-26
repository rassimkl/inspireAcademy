<div class="container">

    <div class="text-center mb-4">
        <h4 class="fw-bold text-primary">🌍 Languages</h4>
    </div>

    {{-- ✅ Formulaire d'ajout --}}
    <div class="card p-4 shadow-sm mb-5">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <input type="text" wire:model.defer="name" class="form-control" placeholder="The Language">
            </div>
            <div class="col-md-5">
                <input type="text" wire:model.defer="description" class="form-control" placeholder="Description (optional)">
            </div>
            <div class="col-md-2 text-end">
                <button wire:click="addLanguage" class="btn btn-primary w-100">
                    + Add
                </button>
            </div>
        </div>
    </div>

    {{-- ✅ Liste des langues --}}
    <div class="row">
        @forelse($languages as $lang)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm border-0 h-100 text-center p-3">
                    <h5 class="text-dark fw-semibold">{{ $lang->name }}</h5>
                    <p class="text-muted small">{{ $lang->description }}</p>
                    
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <a href="{{ route('online_courses.show', $lang->id) }}" class="btn btn-sm btn-outline-primary">
                            courses
                        </a>
                        {{-- 🗑 Bouton Supprimer --}}
                        <button wire:click="deleteLanguage({{ $lang->id }})"
                                onclick="return confirm('Supprimer la langue « {{ $lang->name }} » ?')"
                                class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">Aucune langue disponible pour le moment.</p>
        @endforelse
    </div>

</div>
