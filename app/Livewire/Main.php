<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;
    protected $students;
    public $perPage = 10;
    public $search;
    protected $paginationTheme = 'bootstrap';


    public function clearSearch()
    {
        $this->search = '';
    }
    
    public function updatingSearch()
    {
        
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }
}
