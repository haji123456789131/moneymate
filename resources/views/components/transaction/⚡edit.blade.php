<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\TransactionForm;
use App\Models\Transaction;
use App\Models\Category;

new class extends Component
{
    public TransactionForm $form;

    #[On('edit-transaction')]
    public function editTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->form->setTransaction($transaction);
        Flux::modal('edit-transaction')->show();
    }

    public function updateTransaction()
    {
        $this->form->update();
        Flux::modal('edit-transaction')->close();
        $this->redirectRoute('transaction.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->form->setTransaction($transaction);
        Flux::modal('delete-transaction')->show();
    }

    public function deleteTransaction()
    {
        $this->form->transaction->delete();
        Flux::modal('delete-transaction')->close();
        $this->redirectRoute('transaction.index', navigate: true);
    }
};
?>

<div>
    {{-- Edit Modal --}}
    <flux:modal name="edit-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateTransaction">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Transaksi</flux:heading>
                <flux:text>Ubah detail record transaksi Anda.</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Tipe" wire:model.live="form.type">
                    <flux:select.option value="expense">Pengeluaran</flux:select.option>
                    <flux:select.option value="income">Pemasukan</flux:select.option>
                </flux:select>

                <flux:select label="Kategori" wire:model="form.category_id">
                    @foreach(Category::all() as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Jumlah (Nominal)" type="number" step="0.01" wire:model="form.amount" />

                <flux:input label="Tanggal Transaksi" type="datetime-local" wire:model="form.transaction_date" />

                <flux:textarea label="Deskripsi" wire:model="form.description" />
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
    <flux:modal name="delete-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteTransaction">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Hapus Transaksi</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Apakah Anda yakin? Riwayat transaksi ini akan dihapus secara permanen.</flux:text>
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