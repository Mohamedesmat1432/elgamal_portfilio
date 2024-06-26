<?php

namespace App\Livewire\Roles;

use App\Livewire\Forms\RoleForm;
use App\Traits\NotifyTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleUpdate extends Component
{
    use NotifyTrait;
    public RoleForm $form;

    public function render()
    {
        return view('livewire.roles.role-update', [
            'permissions' => $this->form->permissions(),
        ]);
    }

    #[On('edit-modal')]
    public function editModal($id)
    {
        $this->dispatch('open-modal', 'update-role-modal');
        $this->dispatch('refresh-role-list');
        $this->form->setRole($id);
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('refresh-role-list');
        $this->dispatch('close-modal', 'update-role-modal');
        $this->successNotify(__('trans.message_update_role'));
        $this->dispatch('refresh-partials');
    }
}
