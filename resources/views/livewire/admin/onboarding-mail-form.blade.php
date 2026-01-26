<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Envoi du mail d’entrée – Étudiant</h2>

                
                <button wire:click="previewProgrammePdf" class="btn">
                    📄 Prévisualiser le PDF Programme
                </button>

                <button wire:click="previewConventionPdf" class="btn">
                    📄 Prévisualiser le PDF Convention
                </button>
            </div>
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
            <div class="card-header fw-semibold"> Informations de l’étudiant</div>
            <div class="card-body row g-3">

                <div class="col-md-3">
                    <label class="form-label">Civilité</label>
                    <select class="form-select @error('civilite') is-invalid @enderror" wire:model.live="civilite">
                        <option>Madame</option>
                        <option>Monsieur</option>
                    </select>
                    @error('civilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Prénom</label>
                    <input class="form-control @error('prenom') is-invalid @enderror" wire:model.live="prenom">
                    @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nom</label>
                    <input class="form-control @error('nom') is-invalid @enderror" wire:model.live="nom">
                    @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Téléphone</label>
                    <input class="form-control @error('telephone') is-invalid @enderror" wire:model="telephone">
                    @error('telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Dossier CPF</label>
                    <input class="form-control @error('dossierCpf') is-invalid @enderror" wire:model="dossierCpf">
                    @error('dossierCpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- =========================
              FORMATION
        ========================== --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold"> Informations de la formation</div>
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label">Langue</label>
                    <select class="form-select @error('langue') is-invalid @enderror" wire:model.live="langue">
                        @foreach($langues as $l)
                            <option>{{ $l }}</option>
                        @endforeach
                    </select>
                    @error('langue') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Certification</label>
                    <input class="form-control @error('certification') is-invalid @enderror"
                           wire:model.live="certification">
                    @error('certification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date du début</label>
                    <input type="date" class="form-control @error('dateDu') is-invalid @enderror"
                           wire:model="dateDu">
                    @error('dateDu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de la fin</label>
                    <input type="date" class="form-control @error('dateAu') is-invalid @enderror"
                           wire:model="dateAu">
                    @error('dateAu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Durée</label>
                    <input class="form-control @error('duree') is-invalid @enderror" wire:model.live="duree">
                    @error('duree') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Lieu</label>
                    <input class="form-control @error('lieu') is-invalid @enderror" wire:model="lieu">
                    @error('lieu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Modalités</label>
                    <select class="form-select @error('modalite') is-invalid @enderror" wire:model="modalite">
                        @foreach($modalites as $m)
                            <option>{{ $m }}</option>
                        @endforeach
                    </select>
                    @error('modalite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                                <div class="col-md-4">
                    <label class="form-label">Frais de formation (€)</label>
                    <input type="number"
                           class="form-control @error('fraisFormation') is-invalid @enderror"
                           wire:model.live.lazy="fraisFormation">
                    @error('fraisFormation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Effectif</label>
                    <textarea class="form-control @error('effectif') is-invalid @enderror"
                              wire:model="effectif"></textarea>
                    @error('effectif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>


            </div>
        </div>

        {{-- =========================
             MAIL
        ========================== --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold"> Signataire</div>
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nom du signataire</label>
                    <input class="form-control @error('signataireNom') is-invalid @enderror"
                           wire:model.live="signataireNom">
                    @error('signataireNom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Rôle du signataire</label>
                    <input class="form-control @error('signataireRole') is-invalid @enderror"
                           wire:model.live="signataireRole">
                    @error('signataireRole') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- =========================
             fichier optionnel
        ========================== --}}

        <div class="card mb-4">
    <div class="card-header fw-semibold">Pièce jointe optionnelle</div>
    <div class="card-body row g-3">

        <div class="col-md-12">
            <label class="form-label">Uploader un PDF</label>
            <input type="file"
                   accept="application/pdf"
                   class="form-control @error('uploadedPdf') is-invalid @enderror"
                   wire:model="uploadedPdf">

            @error('uploadedPdf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($uploadedPdfOriginalName)
                <div class="mt-2 text-muted">
                    Fichier sélectionné : <strong>{{ $uploadedPdfOriginalName }}</strong>
                </div>
            @endif
        </div>

    </div>
</div>


        {{-- =========================
             APERÇU MAIL
        ========================== --}}
        <div class="card">
            <div class="card-header fw-semibold">👀 Aperçu du mail</div>
            <div class="card-body">
                <div class="border rounded p-3 bg-white">
                    {!! $this->mailPreview !!}
                </div>
            </div>
        </div>
        
        <button wire:click="sendMail"
        class="btn-mail mt-4"
        wire:loading.attr="disabled">
    <span wire:loading.remove>📧 Envoyer le mail avec les PDF</span>
    <span wire:loading>⏳ Envoi en cours…</span>
</button>

    @if (session()->has('success'))
     <div class="alert alert-success alert-dismissible fade show mt-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
     </div>
    @endif

    </div>
</div>
