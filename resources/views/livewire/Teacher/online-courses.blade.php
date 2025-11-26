<div class="container py-4">
    <h3 class="text-primary fw-bold mb-4">📘 My Online Courses</h3>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Sélecteur de langue --}}
    <div class="card shadow-sm p-3 mb-4">
        <label class="fw-semibold mb-2">Language</label>
        <select wire:model="languageSelected" wire:change="changeLanguage" class="form-select w-50">
            @foreach($languages as $lang)
                <option value="{{ $lang->id }}">{{ $lang->name }}</option>
            @endforeach
        </select>
    </div>

        {{-- ========================================================= --}}
    {{-- 🧩 FORMULAIRE D’AJOUT D’UN NOUVEAU COURS --}}
    {{-- ========================================================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3 fw-bold text-secondary">Add a new cours</h5>

            {{-- 🔸 FORMULAIRE AVEC LIVEWIRE --}}
            <form wire:submit.prevent="save">
                <div class="row g-3 align-items-center">

                    {{-- 🔹 Champ : Titre du cours --}}
                    <div class="col-md-4">
                        <input type="text" wire:model="title" class="form-control" placeholder="Title">
                        @error('title') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    {{-- 🔹 Sélecteur : Niveau (A1, A2, B1...) --}}
                    <div class="col-md-3">
                        <select wire:model="level" class="form-select">
                            <option value="">-- Level --</option>
                            @foreach($levels as $lvl)
                                <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
                            @endforeach
                        </select>
                        @error('level') 
                            <small class="text-danger">{{ $message }}</small> 
                        @enderror
                    </div>

                    {{-- 🔹 Sélecteur de fichier PDF --}}
                    <div class="col-md-3">
                        <div class="input-group">
                            {{-- Bouton principal --}}
                            <label class="btn btn-outline-secondary mb-0">
                                Choose file
                                <input 
                                    type="file" 
                                    id="fileInput"
                                    wire:model="file" 
                                    accept=".pdf" 
                                    hidden
                                    onchange="document.getElementById('fileName').value = this.files.length ? this.files[0].name : 'No file chosen'">
                            </label>

                            {{-- Zone de texte affichant le nom du fichier sélectionné --}}
                            <input type="text" id="fileName" class="form-control bg-white text-muted" 
                                   placeholder="No file chosen" readonly>
                        </div>

                        @error('file') 
                            <small class="text-danger">Please upload a valid PDF file (max size: 5MB)</small> 
                        @enderror
                    </div>

                    {{-- 🔹 Bouton de soumission --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" 
                                wire:loading.attr="disabled"
                                wire:target="file">
                            <span wire:loading.remove wire:target="file">Add</span>
                            <span wire:loading wire:target="file">Uploading...</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    
    {{-- Liste des cours --}}
    <div class="accordion" id="teacherCoursesAccordion">
        @foreach($levels as $lvl)
            <div class="accordion-item mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#lvl-{{ $lvl->id }}">
                        {{ $lvl->name }}
                    </button>
                </h2>
                <div id="lvl-{{ $lvl->id }}" class="accordion-collapse collapse">
                    <div class="accordion-body bg-light">
                        @forelse($courses->where('level_id', $lvl->id) as $course)
                            <div class="d-flex justify-content-between align-items-center bg-white border rounded p-2 mb-2">
                                <div>
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    {{ $course->title }}
                                </div>
                                <div>
                                    <a href="{{ asset('storage/'.$course->file_path) }}" target="_blank"
                                       class="btn btn-sm btn-outline-success me-2">Open</a>
                                    <button wire:click="delete({{ $course->id }})"
                                            class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No courses for this level.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
