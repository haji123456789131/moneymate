<?php

use App\Livewire\Forms\TransactionForm;
use App\Models\Category;
use Livewire\Component;

new class extends Component
{
    public TransactionForm $form;

    public function mount()
    {
        $this->form->transaction_date = now()->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->form->store();
        Flux::modal('create-transaction')->close();
        $this->redirectRoute('transaction.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
        $this->form->transaction_date = now()->format('Y-m-d\TH:i');
    }
};
?>

<div>
    <flux:modal name="create-transaction" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Tambah Transaksi</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Catat pemasukan atau pengeluaran baru.</flux:text>
            </div>

            <div class="space-y-4">
                <flux:select label="Tipe" wire:model.live="form.type">
                    <flux:select.option value="expense">Pengeluaran</flux:select.option>
                    <flux:select.option value="income">Pemasukan</flux:select.option>
                </flux:select>

                <flux:select label="Kategori" wire:model="form.category_id" placeholder="Pilih kategori...">
                    @foreach(Category::all() as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input label="Jumlah (Nominal)" type="number" step="0.01" placeholder="Masukkan nominal uang" wire:model="form.amount" />

                <flux:input label="Tanggal Transaksi" type="datetime-local" wire:model="form.transaction_date" />

                <flux:textarea label="Deskripsi" placeholder="Tambahkan catatan singkat transaksi..." wire:model="form.description" />
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