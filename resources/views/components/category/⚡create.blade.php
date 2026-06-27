<?php
use App\Livewire\Forms\CategoryForm;
use Livewire\Component;

new class extends Component {
    public CategoryForm $form;

    public function save()
    {
        $this->form->store();
        Flux::modal('create-category')->close();
        $this->redirectRoute('category.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};?>

<div>
    <flux:modal name="create-category" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Buat Kategori Baru</flux:heading>
                <flux:text>Tambahkan kategori pos keuangan baru.</flux:text>
            </div>

            <div class="space-y-4">
                <flux:input label="Nama Kategori" placeholder="Contoh: Makanan, Kost" wire:model="form.name" />
                <flux:select label="Tipe Kategori" wire:model="form.type">
                    <flux:select.option value="expense">Pengeluaran (Expense)</flux:select.option>
                    <flux:select.option value="income">Pemasukan (Income)</flux:select.option>
                </flux:select>
                <flux:textarea label="Keterangan (Opsional)" wire:model="form.description" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200">
                <flux:modal.close>
                    <flux:button variant="outline">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="emerald" type="submit">Simpan Kategori</flux:button>
            </div>
        </form>
    </flux:modal>
</div>