<?php

namespace App\Livewire;

use Exception;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Contract;
use App\Models\CourseFile;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[Title('Course')]
class CourseDetails extends Main
{
    protected $listeners = [
        'deleteFile' => 'deleteFile',
        'deleteFilec' => 'deleteFilec'

    ];
    use WithFileUploads;
    public $course;
    public $classCount;
    public $hoursGiven;
    public $hoursRemainig;
    public $doc;
    public $title;

    public $fileId;

    public $perPage = 5;


    protected $rules = [
        'doc' => 'required|file|max:10240', // Adjust the maximum file size as needed (10MB in this example)
        'title' => 'required|string',
    ];





    public function save()
    {
        $this->authorize('addfiletoCourse', $this->course);
        $this->validate();

        try {


            // Generate a unique filename to prevent overwriting existing files
            $filename = $this->doc->getClientOriginalName();
            $randomNumber = uniqid();
            $newFilename = $randomNumber . '_' . $filename;
            $path = $this->doc->storeAs('coursesfiles', $newFilename, 'public');

            // Save file path and associated course ID to the database
            CourseFile::create([
                'course_id' => $this->course->id,
                'title' => $this->title,
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $this->doc->getMimeType(),
            ]);

            $this->dispatch('showAlert', [
                'title' => "File uploaded succesfully",
                'text' => '',
                'icon' => 'success'
            ]);

            $this->reset([
                'title',
                'doc'
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
    public function mount(Course $course)
    {
        //$this->authorize('addClass', $this->course);

        if (!$course) {

            return back();
        }



        $this->course = $course;
        $this->classCount = $course->classes->where('status', 2)->count();
        $this->hoursGiven = $course->classes->where('status', 2)->sum('hours');

    }


    public function cdeleteFile($fileid)
    {
        $this->fileId = $fileid;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete this file', 'deleteFile');

    }

    public function deleteFile()
    {
        try {
            $this->authorize('addfiletoCourse', $this->course);

            // Find the file by ID
            $file = CourseFile::findOrFail($this->fileId);

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


    public function cdeleteFilec($fileid)
    {
        $this->fileId = $fileid;
        $this->dispatch('confirmTask', 'Are you sure you want to Delete this file', 'deleteFilec');

    }

    public function deleteFilec()
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

        $cclasses = $this->course->classes()->orderBy('date', 'asc')->paginate(4);


        return view('livewire.course-details', ['cclasses' => $cclasses]);
    }
}
