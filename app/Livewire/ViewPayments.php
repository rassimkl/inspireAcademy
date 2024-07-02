<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;

#[Title('Payments')]
class ViewPayments extends Main
{


    public $teachers;
    public $selectedTeacher;
    public $selectedMonth;

    public function mount()
    {

        $this->selectedMonth = Carbon::today()->subMonth()->format('m-Y');

        $this->teachers = User::where('user_type_id', 2)->get();
    }

   
    public function render()
    {
        $selectedMonthDate = Carbon::createFromFormat('m-Y', $this->selectedMonth)->startOfMonth();
        $startOfMonth = $selectedMonthDate->copy()->startOfMonth();
        $endOfMonth = $selectedMonthDate->copy()->endOfMonth();

        $paymentsQuery = Payment::query();

        // Apply filter based on selectedTeacher if it is set
        if ($this->selectedTeacher) {
            $paymentsQuery->where('user_id', $this->selectedTeacher);
        }

        // Apply filter for the date range
        $paymentsQuery->whereBetween('payment_date', [$startOfMonth, $endOfMonth]);

        // Retrieve all payments without pagination
        $allPayments = $paymentsQuery->get();

        // Calculate the total sum of amounts
        $totalAmount = $allPayments->sum('amount');

        // Paginate the payments
        $payments = $paymentsQuery->paginate($this->perPage);

        return view('livewire.view-payments', [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
        ]);
    }

}
