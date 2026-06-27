<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\BudgetForm;
use App\Models\Budget;
use App\Models\Category;

new class extends Component
{
    public BudgetForm $form;

    #[On('edit-budget')]
    public function editBudget($id)
    {
        $budget = Budget::findOrFail($id);
        $this->form->setBudget($budget);
        Flux::modal('edit-budget')->show();
    }

    public function updateBudget()
    {
        $this->form->update();
        Flux::modal('edit-budget')->close();
        $this->redirectRoute('budget.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $budget = Budget::findOrFail($id);
        $this->form->setBudget($budget);
        Flux::modal('delete-budget')->show();
    }

    public function deleteBudget()
    {
        $this->form->budget->delete();
        Flux::modal('delete-budget')->close();
        $this->redirectRoute('budget.index', navigate: true);
    }
};
?>

<div>
    {{-- Edit Modal --}}
    <flux:modal name="edit-budget" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateBudget">
            <div class="space-y-2">
                <flux:heading size="lg">Ubah Batas Anggaran</flux:heading>
                <flux:text font-size="sm">Perbarui batas rencana alokasi anggaran Anda.</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Kategori" wire:model="form.category_id">
                    @foreach(Category::all() as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Batas Nominal (Limit Amount)" type="number" step="0.01" wire:model="form.limit_amount" />

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
                <flux:button variant="primary" color="emerald" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Modal --}}
    <flux:modal name="delete-budget" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteBudget">
            <div class="space-y-2">
                <flux:heading size="lg">Hapus Anggaran</flux:heading>
                <flux:text>Tindakan ini tidak dapat dibatalkan. Record anggaran terpilih akan dihapus.</flux:text>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>