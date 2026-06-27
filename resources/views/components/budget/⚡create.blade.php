<?php

use App\Livewire\Forms\BudgetForm;
use App\Models\Category;
use Livewire\Component;

new class extends Component
{
    public BudgetForm $form;

    public function mount()
    {
        $this->form->month = date('n');
        $this->form->year = date('Y');
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-budget')->close();
        $this->redirectRoute('budget.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
        $this->form->month = date('n');
        $this->form->year = date('Y');
    }
};
?>

<div>
    <flux:modal name="create-budget" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Tambah Batas Anggaran</flux:heading>
                <flux:text>Tetapkan rencana pengeluaran maksimum bulanan.</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Kategori" wire:model="form.category_id" placeholder="Pilih kategori...">
                    @foreach(Category::all() as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Batas Nominal (Limit Amount)" type="number" step="0.01" placeholder="Contoh: 500000" wire:model="form.limit_amount" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:select label="Bulan" wire:model="form.month">
                        @foreach(range(1, 12) as $m)
                            <flux:select.option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select label="Tahun" wire:model="form.year">
                        @foreach(range(date('Y') - 1, date('Y') + 3) as $y)
                            <flux:select.option value="{{ $y }}">{{ $y }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="emerald" type="submit">Simpan</flux:button>
            </div>
        </form>
    </flux:modal>
</div>