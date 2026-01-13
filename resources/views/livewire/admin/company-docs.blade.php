<div class="page-wrapper">
    <div class="content container-fluid">

        <h3>📁 Docs entreprise</h3>

        {{-- ZIP --}}
        <div wire:loading wire:target="downloadAllDocs" class="text-info mb-2">
            📦 Génération du ZIP...
        </div>

        <button wire:click="downloadAllDocs" class="btn btn-dark mb-3">
            <span wire:loading.remove wire:target="downloadAllDocs">
                ⬇️ Télécharger tout le dossier (ZIP)
            </span>
            <span wire:loading wire:target="downloadAllDocs">
                ⏳ Préparation du ZIP...
            </span>
        </button>

        {{-- Navigation --}}
        @if(!$this->isRoot())
            <button class="btn btn-secondary mb-3" wire:click="back">
                ← Retour
            </button>
        @endif

        {{-- =========================
            CRÉATION DOSSIER (TOUJOURS EN HAUT)
        ========================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5>Créer un dossier</h5>
                <div class="d-flex gap-2">
                    <input
                        type="text"
                        wire:model="newFolderName"
                        class="form-control"
                        placeholder="Nom du dossier"
                    >
                    <button wire:click="createFolder" class="btn btn-primary">
                        Ajouter
                    </button>
                </div>
                @error('newFolderName')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- =========================
            UPLOAD (JUSTE APRÈS)
        ========================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5>📄 Fichiers</h5>

                <input type="file" wire:model="uploadedFile" class="form-control mb-2">

                <div wire:loading wire:target="uploadedFile" class="text-info mb-2">
                    📤 Chargement du fichier...
                </div>

                <button
                    wire:click="uploadFile"
                    wire:loading.attr="disabled"
                    wire:target="uploadedFile,uploadFile"
                    class="btn btn-success mb-3"
                >
                    <span wire:loading.remove wire:target="uploadFile">
                        Upload fichier
                    </span>
                    <span wire:loading wire:target="uploadFile">
                        ⏳ Upload en cours...
                    </span>
                </button>

                @error('uploadedFile')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- =========================
            DOSSIERS (EN DESSOUS)
        ========================= --}}
        @if(count($this->folders))
            <div class="card mb-4">
                <div class="card-body">
                    <h5>📁 Dossiers</h5>

                    @foreach ($this->folders as $folder)
                        <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                            <span>
                                <i class="fas fa-folder text-warning"></i>
                                {{ $folder }}
                            </span>

                            <div class="d-flex gap-2">
                                <button
                                    class="btn btn-sm btn-outline-primary"
                                    wire:click="openFolder('{{ $folder }}')"
                                >
                                    Ouvrir
                                </button>

                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="confirmDelete('{{ $folder }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- =========================
            LISTE DES FICHIERS (TOUT EN BAS)
        ========================= --}}
        <div class="card">
            <div class="card-body">
                <h5>📄 Liste des fichiers</h5>

                <ul class="list-group">
                    @forelse($this->files as $file)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $file }}
                            <button
                                wire:click="deleteFile('{{ $file }}')"
                                class="btn btn-sm btn-danger"
                            >
                                Supprimer
                            </button>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">
                            Aucun fichier
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- CONFIRMATION SUPPRESSION --}}
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('confirmDelete', (data) => {
                    Swal.fire({
                        title: 'Confirmation',
                        text: data.text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteFolderConfirmed');
                        }
                    });
                });
            });
        </script>

    </div>
</div>
