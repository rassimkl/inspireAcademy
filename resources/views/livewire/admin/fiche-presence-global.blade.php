<div class="page-wrapper">
    <div class="content container-fluid">
        <h3>Export global des fiches de présence</h3>

        <div class="form-group mt-3 w-25">
            <label>Année</label>
            <select wire:model="year" class="form-control">
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>
        </div>

        <button wire:click="downloadZip" class="btn btn-primary mt-3">
            Télécharger toutes les fiches (ZIP)
        </button>
    </div>
</div>
