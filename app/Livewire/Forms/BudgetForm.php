<?php

namespace App\Livewire\Forms;

use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BudgetForm extends Form
{
    public ?Budget $budget = null;

    public string $category_id = '';
    public string $limit_amount = '';
    public string $month = '';
    public string $year = '';

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'limit_amount' => ['required', 'numeric', 'min:0'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'min:2020', 'max:' . (date('Y') + 5)],
        ];
    }

    public function setBudget(Budget $budget): void
    {
        $this->budget = $budget;
        $this->category_id = $budget->category_id;
        $this->limit_amount = $budget->limit_amount;
        $this->month = $budget->month;
        $this->year = $budget->year;
    }

    public function store()
    {
        $this->validate([
            'category_id' => [
                Rule::unique('budgets')->where(function ($query) {
                    return $query->where('user_id', Auth::id())
                        ->where('month', $this->month)
                        ->where('year', $this->year);
                })->ignore($this->budget?->id)
            ]
        ] + $this->rules());

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'limit_amount' => $this->limit_amount,
            'month' => $this->month,
            'year' => $this->year,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate([
            'category_id' => [
                Rule::unique('budgets')->where(function ($query) {
                    return $query->where('user_id', Auth::id())
                        ->where('month', $this->month)
                        ->where('year', $this->year);
                })->ignore($this->budget->id)
            ]
        ] + $this->rules());

        $this->budget->update([
            'category_id' => $this->category_id,
            'limit_amount' => $this->limit_amount,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }
}