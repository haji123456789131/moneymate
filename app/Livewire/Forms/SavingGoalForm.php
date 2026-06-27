<?php

namespace App\Livewire\Forms;

use App\Models\SavingGoal;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class SavingGoalForm extends Form
{
    public string $title = '';
    public string $target_amount = '';
    public string $current_amount = '0';
    public string $deadline = '';

    public ?SavingGoal $savingGoal = null;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'current_amount' => ['required', 'numeric', 'min:0'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function setSavingGoal(SavingGoal $savingGoal): void
    {
        $this->savingGoal = $savingGoal;
        $this->title = $savingGoal->title;
        $this->target_amount = $savingGoal->target_amount;
        $this->current_amount = $savingGoal->current_amount;
        $this->deadline = $savingGoal->deadline->format('Y-m-d');
    }

    public function store()
    {
        $this->validate();

        SavingGoal::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'target_amount' => $this->target_amount,
            'current_amount' => $this->current_amount,
            'deadline' => $this->deadline,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->savingGoal->update([
            'title' => $this->title,
            'target_amount' => $this->target_amount,
            'current_amount' => $this->current_amount,
            'deadline' => $this->deadline,
        ]);
    }
}