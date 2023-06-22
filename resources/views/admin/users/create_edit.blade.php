<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Usuários >
            <x-admin.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.users.index')">
            Listar Usuários
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form :action="$item->id ? route('admin.users.update', $item->id) : route('admin.users.store')" :editing="(bool) $item->id">
            <x-admin.form-grid gridCols="sm:grid-cols-3" x-data="{!! $item->id ? '{changePass: ' . (old() && old('changePass') == 'checked' ? 'true' : 'false') . '}' : '' !!}">
                <x-admin.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.form-select>
                <x-admin.form-label inpName="name" title="Nome">
                    <x-admin.form-input inpName="name" placeholder="Nome do usuário" :inpValue="old('name') ?: $item->name"
                        required />
                </x-admin.form-label>
                <x-admin.form-label inpName="email" title="Login do Usuário">
                    <x-admin.form-input inpName="email" type="email" placeholder="usuario@login.com.br"
                        :inpValue="old('email') ?: $item->email" required />
                </x-admin.form-label>
                @if ($item->id)
                    <x-admin.form-label inpName="changePass" title="Alterar Senha?">
                        <x-admin.form-check-toggle inpName="changePass" title="Alterar senha do usuário"
                            :checked="old() && old('changePass') == 'checked'" x-on:change="changePass = !changePass" />
                    </x-admin.form-label>
                @endif
                <x-admin.form-label inpName="password" title="Senha do Usuário">
                    <x-admin.form-input inpName="password" type="password" placeholder="••••••••"
                        required ::disabled="{{ $item->id ? '!changePass ? true : false' : 'false' }}" />
                </x-admin.form-label>
                <x-admin.form-label inpName="password_confirmation" title="Confirme a Senha do Usuário">
                    <x-admin.form-input inpName="password_confirmation" type="password"
                        placeholder="••••••••" required ::disabled="{{ $item->id ? '!changePass ? true : false' : 'false' }}" />
                </x-admin.form-label>
            </x-admin.form-grid>
        </x-admin.form>
    </x-admin.list-section>
</x-admin-layout>
