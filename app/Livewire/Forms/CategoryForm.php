<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryForm extends Form
{
    public string $name = '';
    public string $type = 'expense'; // Default pengeluaran mahasiswa
    public string $description = '';
    public ?Category $category = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                // Validasi unique berdasarkan kombinasi nama DAN tipe kategori
                Rule::unique('categories', 'name')
                    ->where('type', $this->type)
                    ->ignore($this->category?->id),
            ],
            'type' => ['required', 'in:income,expense'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->type = $category->type;
        $this->description = $category->description ?? '';
    }

    public function store()
    {
        $this->validate();
        Category::create($this->only(['name', 'type', 'description']));
        $this->reset(['name', 'description']); // Tetap pertahankan tipe yang dipilih sebelumnya
    }

    public function update()
    {
        $this->validate();
        $this->category->update($this->only(['name', 'type', 'description']));
    }
}