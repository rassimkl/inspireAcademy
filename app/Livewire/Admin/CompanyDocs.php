<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class CompanyDocs extends Component
{
    use WithFileUploads;

    /** Racine */
    public string $basePath = 'docs-entreprise';

    /** Dossier courant */
    public string $currentPath = 'docs-entreprise';

    /** Suppressions */
    public ?string $folderToDelete = null;
    public ?string $fileToDelete = null;

    /** Form */
    public string $newFolderName = '';
    public $uploadedFile;

    protected $listeners = [
        'deleteFolderConfirmed',
        'deleteFileConfirmed',
    ];

    public function mount()
    {
        if (Auth::user()->user_type_id !== 1) {
            abort(403);
        }

        if (!Storage::exists($this->basePath)) {
            Storage::makeDirectory($this->basePath);
        }
    }

    /* ======================
        NAVIGATION
    ====================== */

    public function openFolder(string $folder)
    {
        $this->currentPath .= '/' . $folder;
    }

    public function back()
    {
        if ($this->currentPath === $this->basePath) {
            return;
        }

        $this->currentPath = dirname($this->currentPath);

        if ($this->currentPath === '.' || $this->currentPath === '') {
            $this->currentPath = $this->basePath;
        }
    }

    public function isRoot(): bool
    {
        return $this->currentPath === $this->basePath;
    }

    /* ======================
        DOSSIERS
    ====================== */

    public function createFolder()
    {
        $this->validate([
            'newFolderName' => 'required|string|max:50',
        ]);

        $folder = Str::slug($this->newFolderName);
        $path = $this->currentPath . '/' . $folder;

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        $this->newFolderName = '';
    }

    public function confirmDelete(string $folder)
    {
        $this->folderToDelete = $folder;

        $this->dispatch('confirmDelete', [
            'text' => "Supprimer définitivement le dossier '{$folder}' ?",
        ]);
    }

    public function deleteFolderConfirmed()
    {
        if (!$this->folderToDelete) {
            return;
        }

        $path = $this->currentPath . '/' . $this->folderToDelete;

        if (Storage::exists($path)) {
            Storage::deleteDirectory($path);
        }

        $this->folderToDelete = null;
    }

    /* ======================
        FICHIERS
    ====================== */

    public function uploadFile()
    {
        $this->validate([
            'uploadedFile' => 'required|file|max:10240',
        ]);

        $this->uploadedFile->storeAs(
            $this->currentPath,
            $this->uploadedFile->getClientOriginalName()
        );

        $this->uploadedFile = null;
    }

    public function confirmDeleteFile(string $file)
    {
        $this->fileToDelete = $file;

        $this->dispatch('confirmDeleteFile', [
            'text' => "Supprimer définitivement le fichier '{$file}' ?",
        ]);
    }

    public function deleteFileConfirmed()
    {
        if (!$this->fileToDelete) {
            return;
        }

        $path = $this->currentPath . '/' . $this->fileToDelete;

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $this->fileToDelete = null;
    }

    /* ======================
        GETTERS
    ====================== */

    public function getFoldersProperty()
    {
        return collect(Storage::directories($this->currentPath))
            ->map(fn ($dir) => basename($dir));
    }

    public function getFilesProperty()
    {
        return collect(Storage::files($this->currentPath))
            ->map(fn ($file) => basename($file));
    }

    /* ======================
        ZIP GLOBAL
    ====================== */

    public function downloadAllDocs()
    {
        $zipPath = storage_path('app/docs-entreprise.zip');

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach (Storage::allFiles($this->basePath) as $file) {
            $zip->addFile(
                storage_path('app/' . $file),
                str_replace($this->basePath . '/', '', $file)
            );
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function render()
    {
        return view('livewire.admin.company-docs');
    }
}
