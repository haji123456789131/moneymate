<?php

use App\Livewire\Forms\SavingGoalForm;
use Livewire\Component;

new class extends Component
{
    public SavingGoalForm $form;

    public function save()
    {
        $this->form->store();
        Flux::modal('create-saving-goal')->close();

        session()->flash('success', 'Saving goal created successfully!');

        $this->redirectRoute('saving-goal.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-saving-goal" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Create Saving Goal</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Set up a new target for your future plans.</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input label="Title / Goal Name" placeholder="e.g., Buy New Laptop, Vacation" wire:model="form.title" />

                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="Target Amount" type="number" placeholder="0.00" wire:model="form.target_amount" />
                    <flux:input label="Current Amount Started" type="number" placeholder="0.00" wire:model="form.current_amount" />
                </div>

                <flux:input label="Deadline" type="date" wire:model="form.deadline" />
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create Goal</flux:button>
            </div>
        </form>
    </flux:modal>
</div>