<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\SavingGoalForm;
use App\Models\SavingGoal;

new class extends Component
{
    public SavingGoalForm $form;

    #[On('edit-saving-goal')]
    public function editSavingGoal($id){
        $goal = SavingGoal::find($id);
        $this->form->setSavingGoal($goal);
        Flux::modal('edit-saving-goal')->show();
    }

    public function updateSavingGoal() {
        $this->form->update();
        Flux::modal('edit-saving-goal')->close();
        session()->flash('success', 'Saving goal updated successfully');
        $this->redirectRoute('saving-goal.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $goal = SavingGoal::find($id);
        $this->form->setSavingGoal($goal);
        Flux::modal('delete-saving-goal')->show();
    }

    public function deleteSavingGoal() {
        $this->form->savingGoal->delete();
        Flux::modal('delete-saving-goal')->close();
        session()->flash('success', 'Saving goal deleted successfully');
        $this->redirectRoute('saving-goal.index', navigate: true);
    }
};
?>

<div>
    {{-- Modal Edit --}}
    <flux:modal name="edit-saving-goal" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="updateSavingGoal">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Edit Saving Goal</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Update your progression or details below.</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input label="Title / Goal Name" wire:model="form.title" wire:dirty.class.text-red-500 />

                <div class="grid grid-cols-2 gap-4">
                    <flux:input label="Target Amount" type="number" wire:model="form.target_amount" wire:dirty.class.text-red-500 />
                    <flux:input label="Current Amount" type="number" wire:model="form.current_amount" wire:dirty.class.text-red-500 />
                </div>

                <flux:input label="Deadline" type="date" wire:model="form.deadline" wire:dirty.class.text-red-500 />
            </div>

            <div wire:show="$dirty" class="text-red-500 dark:text-red-400">you have unsaved changes</div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Modal Konfirmasi Delete --}}
    <flux:modal name="delete-saving-goal" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="deleteSavingGoal">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Delete Saving Goal</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Are you sure? This action cannot be undone.</flux:text>
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