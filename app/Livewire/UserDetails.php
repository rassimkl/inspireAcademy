<?php

namespace App\Livewire;

use Exception;
use App\Models\User;
use Livewire\Component;
use App\Models\Contract;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;

#[Title('User')]
class UserDetails extends Component
{
    use WithFileUploads;
    protected $listeners = [
        'deleteFile' => 'deleteFile',

    ];
    public $user;
    public $courses;

    public $contract;
    public $fileId;

    public $classesCount;

    protected $rules = [
        'contract' => 'required|file|max:10240', // Adjust the maximum file size as needed (10MB in this example)

    ];

    public function mount(User $user)
    {
        if (!$user) {

            return back();
        }

        $this->user = $user;
        if ($user->user_type_id == 3) {
            $this->courses = $user->coursesAsStudent()
                ->withCount([
                    'classes' => function ($query) {
                        $query->where('status', '=', '2');
                    }
                ])->withSum([
                        'classes' => function ($query) {
                            $query->where('status', 2);
                        }
                    ], 'hours')
                ->get();
        } elseif ($user->user_type_id == 2) {

            $this->courses = $user->coursesAsTeacher()
                ->withCount([
                    'classes' => function ($query) {
                        $query->where('status', '=', '2');
                    }
                ])->withSum([
                        'classes' => function ($query) {
                            $query->where('status', 2);
                        }
                    ], 'hours')
                ->get();
        } elseif ($user->user_type_id == 4) {

            $this->courses = $user->coursesAsStudent()
                ->withCount([
                    'classes' => function ($query) {
                        $query->where('status', '=', '2');
                    }
                ])->withSum([
                        'classes' => function ($query) {
                            $query->where('status', 2);
                        }
                    ], 'hours')
                ->get();
        }




        $classesCount = 0;
        foreach ($this->courses as $course) {


            $classesCount += $course->classes_count;

        }
        $this->classesCount = $classesCount;
    }
    public function save()
    {
        $this->authorize('viewAdmin', auth()->user()->userType);
        $this->validate();

        try {


            // Generate a unique filename to prevent overwriting existing files
            $filename = $this->contract->getClientOriginalName();
            $randomNumber = uniqid();
            $newFilename = $randomNumber . '_' . $filename;
            $path = $this->contract->storeAs('contracts', $newFilename, 'public');

            // Save file path and associated course ID to the database
            Contract::create([
                'course_id' => null,
                'user_id' => $this->user->id,
                'title' => $this->user->first_name,
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $this->contract->getMimeType(),
            ]);

            $this->dispatch('showAlert', [
                'title' => "File uploaded succesfully",
                'text' => '',
                'icon' => 'success'
            ]);

            $this->reset([
                'contract',

            ]);



        } catch (Exception $e) {
            // Display error message using SweetAlert
            $errorMessage = 'An error occurred while uploading the file';

            $this->dispatch('showAlert', [
                'title' => "error",
                'text' => $errorMessage,
                'icon' => 'warning'
            ]);

        }
    }

    public function cdeleteFile($fileid)
    {
        $this->fileId = $fileid;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete this file', 'deleteFile');

    }

    public function deleteFile()
    {
        try {
            $this->authorize('viewAdmin', auth()->user()->userType);

            // Find the file by ID
            $file = Contract::findOrFail($this->fileId);

            // Delete the file from storage
            // Storage::delete($file->path);
            Storage::disk('public')->delete($file->path);
            // Delete the file record from the database
            $file->delete();
            $this->dispatch('showAlert', [
                'title' => "File deleted succesfully",
                'text' => '',
                'icon' => 'success'
            ]);
            $this->reset(['fileId']);


        } catch (Exception $e) {
            // Log the exception or handle it as needed

            $this->dispatch('showAlert', [
                'title' => "error",
                'text' => 'Error deleting File',
                'icon' => 'warning'
            ]);

        }


    }


    public function render()
    {
        return view('livewire.user-details');
    }
}
