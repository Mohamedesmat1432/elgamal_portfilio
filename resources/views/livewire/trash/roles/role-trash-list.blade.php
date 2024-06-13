<div>
    @can('role-restore')
        <livewire:trash.roles.role-restore />
    @endcan

    @can('role-bulk-restore')
        <livewire:trash.roles.role-bulk-restore />
    @endcan

    @can('role-force-delete')
        <livewire:trash.roles.role-force-delete />
    @endcan

    @can('role-force-bulk-delete')
        <livewire:trash.roles.role-force-bulk-delete />
    @endcan

    <div class="px-8 py-6 mx-8 mt-8">
        <div class="flex">
            <x-text-input type="search" wire:model.live.debounce.500ms="search" placeholder="{{ __('trans.search') }}..."
                id="roleSearch" name="search" />

            @can('role-bulk-restore')
                @if (count($this->form->ids) > 0)
                    <x-primary-button class="mx-2"
                        x-on:click.prevent="$dispatch('bulk-restore-modal', {ids: '{{ json_encode($this->form->ids) }}'})">
                        <x-icon name="arrow-uturn-left" class="w-4 h-4 text-white inline-block" />
                        {{ __('trans.restore') }}
                    </x-primary-button>
                @endif
            @endcan
        </div>

        <div class="mt-2">
            @can('role-force-bulk-delete')
                @if (count($this->form->ids) > 0)
                    <x-danger-button
                        x-on:click.prevent="$dispatch('force-bulk-delete-modal', {ids: '{{ json_encode($this->form->ids) }}'})">
                        <x-icon name="trash" class="w-4 h-4 text-white inline-block" />
                        <span>{{ __('trans.delete_all') }} {{ count($this->form->ids) }}</span>
                    </x-danger-button>
                @endif
            @endcan
        </div>
    </div>

    <x-table>
        {{-- thead --}}
        <x-slot name="thead">
            <tr>
                @can('role-force-bulk-delete')
                    <th class="px-6 py-4">
                        <x-text-input class="cursor-pointer" type="checkbox" wire:model="form.select_all"
                            wire:click="selectAll" id="roleSelectAll" name="select_all" />
                    </th>
                @endcan
                <th class="px-6 py-4">
                    <button wire:click="sortBy('id')" class="flex justify-center w-full">
                        #
                        <x-sort-icon field="id" :sort_by="$sort_by" :sort_dir="$sort_dir" />
                    </button>
                </th>
                <th class="px-6 py-4">
                    <button wire:click="sortBy('name')" class="flex justify-center w-full">
                        {{ __('trans.name') }}
                        <x-sort-icon field="name" :sort_by="$sort_by" :sort_dir="$sort_dir" />
                    </button>
                </th>
                <th class="px-6 py-4">
                    {{ __('trans.action') }}
                </th>
            </tr>
        </x-slot>
        {{-- tbody --}}
        <x-slot name="tbody">
            @forelse ($this->roles() as $role)
                <tr wire:key="trash-role-{{ $role->id }}" class="border-b border-neutral-200">
                    @can('role-bulk-delete')
                        <td class="px-6 py-4">
                            <x-text-input class="cursor-pointer" type="checkbox" wire:model.live="form.ids"
                                value="{{ $role->id }}" id="roleIds" name="ids" />
                        </td>
                    @endcan
                    <td class="px-6 py-4 font-medium">
                        {{ $role->id }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $role->name }}
                    </td>
                    <td class="px-6 py-4">
                        @can('role-restore')
                            <x-icon name="arrow-uturn-left" class="w-10 h-10 inline-block cursor-pointer"
                                x-on:click.prevent="$dispatch('restore-modal', {id: '{{ $role->id }}', name: '{{ $role->name }}'})" />
                        @else
                            <x-icon name="arrow-uturn-left" class="w-10 h-10 inline-block cursor-not-allowed" />
                        @endcan

                        @can('role-force-delete')
                            <x-icon name="trash" class="w-10 h-10 text-red-600 inline-block cursor-pointer"
                                x-on:click.prevent="$dispatch('force-delete-modal', {id: '{{ $role->id }}', name: '{{ $role->name }}'})" />
                        @else
                            <x-icon name="trash" class="w-10 h-10 text-red-300 inline-block cursor-not-allowed" />
                        @endcan
                    </td>
                </tr>
            @empty
                <tr class="border-b border-neutral-200">
                    <td class="px-6 py-4" colspan="3">
                        {{ __('trans.empty_data') }}
                    </td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{-- pagination --}}
    <div class="px-8 mx-8 my-3 py-3">
        {{ $this->roles()->withQueryString()->links() }}
    </div>
</div>
