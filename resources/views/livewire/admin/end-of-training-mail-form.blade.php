<div class="page-wrapper">
    <div class="content container-fluid">

        {{-- =========================
            HEADER
        ========================== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">📩 Mail de fin de formation – Étudiant</h2>
        </div>

                <div class="d-flex gap-2 mb-4">
            <button
                wire:click="previewAttestationPdf"
                class="btn btn-light btn-sm"
            >
                👁️ Prévisualiser l’attestation
            </button>

            <button
                wire:click="previewCertificatPdf"
                class="btn btn-light btn-sm"
            >
                👁️ Prévisualiser le certificat
            </button>
        </div>

        <script>
            window.addEventListener('openPdfPreview', event => {
                window.open(event.detail, '_blank');
            });
        </script>

        {{-- =========================
            INFORMATIONS ÉTUDIANT
        ========================== --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Informations de l’étudiant</div>

            <div class="card-body row g-3">

                <div class="col-md-3">
                    <label class="form-label">Civilité</label>
                    <select class="form-select" wire:model.live="civilite">
                        <option>Madame</option>
                        <option>Monsieur</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Prénom</label>
                    <input class="form-control" wire:model.live="prenom">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nom</label>
                    <input class="form-control" wire:model.live="nom">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" wire:model="email">
                </div>

            </div>
        </div>

        {{-- =========================
            INFORMATIONS FORMATION
        ========================== --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Informations de la formation</div>

            <div class="card-body row g-3">

                <div class="col-12">
                    <label class="form-label">
                        Titre de la formation
                        <small class="text-muted">(70 caractères maximum)</small>
                    </label>

                    <input type="text"
                           class="form-control @error('titreFormation') is-invalid @enderror"
                           wire:model.live.debounce.500ms="titreFormation">

                    @error('titreFormation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="text-end small {{ strlen($titreFormation) > 70 ? 'text-danger' : 'text-muted' }}">
                        {{ strlen($titreFormation) }}/70
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Langue</label>
                    <select class="form-select @error('langue') is-invalid @enderror"
                            wire:model.live="langue">
                        @foreach($langues as $l)
                            <option>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('langue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de début</label>
                    <input type="date" class="form-control" wire:model="dateDu">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de fin</label>
                    <input type="date" class="form-control" wire:model="dateAu">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Durée totale (heures)</label>
                    <input class="form-control" wire:model="duree">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nature de la formation</label>
                    <select class="form-select" wire:model="natureFormation">
                        <option value="action de formation">Action de formation</option>
                        <option value="bilan de compétences">Bilan de compétences</option>
                        <option value="action de VAE">Action de VAE</option>
                        <option value="action de formation par apprentissage">
                            Action de formation par apprentissage
                        </option>
                    </select>
                </div>


            </div>
        </div>

        {{-- =========================
            texte optionnel
        ========================== --}}

        <div class="card mb-4">
    <div class="card-header fw-semibold">Texte optionnel (modifiable)</div>

    <div class="card-body row g-3">

        <div class="col-12">

            <textarea
                class="form-control"
                rows="3"
                wire:model.live="texteOptionnel">
            </textarea>
        </div>

        <div class="col-12">
            <div class="form-check mt-2">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model.live="afficherTexteOptionnel"
                    id="afficherTexteOptionnel">

                <label class="form-check-label" for="afficherTexteOptionnel">
                    Ajouter ce texte dans le mail
                </label>
            </div>
        </div>

    </div>
</div>


        {{-- =========================
            SIGNATAIRE
        ========================== --}}
         <div class="card mb-4">
            <div class="card-header fw-semibold">Signataire</div>
            <div class="card-body row g-3">

                <select class="form-select @error('signataireId') is-invalid @enderror"
                        wire:model="signataireId">
                    <option value="">— Sélectionner un signataire —</option>

                    @foreach($this->signataires as $signataire)
                        <option value="{{ $signataire->id }}">
                            {{ $signataire->nom }} — {{ $signataire->role }}
                        </option>
                    @endforeach
                </select>

                @error('signataireId')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>
        </div>

        {{-- =========================
            APERÇU DU MAIL
        ========================== --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">👀 Aperçu du mail</div>

            <div class="card-body">
                <div class="border rounded p-3 bg-white">
                    {!! $this->mailPreview !!}
                </div>
            </div>
        </div>

        {{-- =========================
            ENVOI
        ========================== --}}
        <button
            wire:click="sendMail"
            class="btn btn-primary"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>📧 Envoyer le mail de fin de formation</span>
            <span wire:loading>⏳ Envoi en cours…</span>
        </button>

        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

    </div>
</div>
