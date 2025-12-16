<div class="container mt-4">

    {{-- ========================================================= --}}
    {{-- 🟦 TITRE PRINCIPAL --}}
    {{-- ========================================================= --}}
    <h2 class="mb-4 text-primary">
        📘 {{ $language->name }} — Cours
    </h2>

    {{-- ========================================================= --}}
    {{-- 🟢 MESSAGE DE SUCCÈS (AFFICHÉ APRÈS UNE ACTION) --}}
    {{-- ========================================================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


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


    {{-- ========================================================= --}}
    {{-- 📚 LISTE DES COURS PAR NIVEAU (ACCORDÉON) --}}
    {{-- ========================================================= --}}
    <div class="accordion" id="coursesAccordion">

        @foreach($levels as $lvl)
            <div class="accordion-item shadow-sm mb-3 border-0">

                {{-- 🔹 En-tête du niveau (bouton accordéon) --}}
                <h2 class="accordion-header" id="heading-{{ $lvl->id }}">
                    <button class="accordion-button collapsed fw-semibold text-secondary" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse-{{ $lvl->id }}" 
                            aria-expanded="false" 
                            aria-controls="collapse-{{ $lvl->id }}">
                        <i class="fas fa-chevron-right me-2 text-muted"></i> 
                        {{ $lvl->name }}
                    </button>
                </h2>

                {{-- 🔹 Contenu des cours du niveau --}}
                <div id="collapse-{{ $lvl->id }}" 
                     class="accordion-collapse collapse" 
                     aria-labelledby="heading-{{ $lvl->id }}" 
                     data-bs-parent="#coursesAccordion">

                    <div class="accordion-body bg-light">

                        {{-- 🧾 Liste des fichiers PDF associés à ce niveau --}}
                        @forelse($courses->where('level_id', $lvl->id) as $course)

                            <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2 bg-white shadow-sm file-item">

                                {{-- 📄 Icône + Nom du fichier (téléchargement direct) --}}
                                <div class="d-flex align-items-center">
                                    <a href="{{ asset('storage/'.$course->file_path) }}" 
                                       download 
                                       class="text-decoration-none d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger fa-lg me-3"></i>
                                        <span class="fw-semibold text-dark hover-underline">{{ $course->title }}.pdf</span>
                                    </a>
                                </div>

                                {{-- 🟢 Boutons d’action : Open / Delete --}}
                                <div>
                                    <a href="{{ asset('storage/'.$course->file_path) }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-outline-success me-2">
                                        <i class="fas fa-eye"></i> Open
                                    </a>

                                    <button wire:click="delete({{ $course->id }})"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                        @empty
                            {{-- Aucun cours trouvé pour ce niveau --}}
                            <p class="text-muted mb-0">No cours.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        @endforeach

    </div>


    {{-- ========================================================= --}}
    {{-- 🧠 SCRIPT : RÉINITIALISER LE CHAMP FICHIER APRÈS AJOUT --}}
    {{-- ========================================================= --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('reset-file-input', () => {
                document.getElementById('fileInput').value = '';
                document.getElementById('fileName').value = 'No file chosen';
            });
        });
    </script>

</div>
