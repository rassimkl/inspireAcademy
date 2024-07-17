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


    public $sortField = 'id';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

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
