<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Usuários >
            <x-admin.layout.sections.page-subtitle>
                {{ $item->id ? 'Alterar' : 'Cadastrar' }}
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.users.index')">
            Listar Usuários
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="$item->id ? route('admin.users.update', $item->id) : route('admin.users.store')" :editing="(bool) $item->id">
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3" x-data="{!! $item->id ? '{changePass: ' . (old() && old('changePass') == 'checked' ? 'true' : 'false') . '}' : '' !!}">
                <x-admin.layout.sections.form-select inpName="status" title="Status" required>
                    @foreach (\App\Helpers\DefaultStatus::array() as $statusKey => $statusValue)
                        <x-admin.layout.sections.form-select-option :inpValue="$statusKey" :title="$statusValue"
                            :selected="(old('status') ?: $item->status?->value) == $statusKey" />
                    @endforeach
                </x-admin.layout.sections.form-select>
                <x-admin.layout.sections.form-label inpName="name" title="Nome">
                    <x-admin.layout.sections.form-input inpName="name" placeholder="Nome do usuário" :inpValue="old('name') ?: $item->name"
                        required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="email" title="Login do Usuário">
                    <x-admin.layout.sections.form-input inpName="email" type="email" placeholder="usuario@login.com.br"
                        :inpValue="old('email') ?: $item->email" required />
                </x-admin.layout.sections.form-label>
                @if ($item->id)
                    <x-admin.layout.sections.form-label inpName="changePass" title="Alterar Senha?">
                        <x-admin.layout.sections.form-check-toggle inpName="changePass" title="Alterar senha do usuário"
                            :checked="old() && old('changePass') == 'checked'" x-on:change="changePass = !changePass" />
                    </x-admin.layout.sections.form-label>
                @endif
                <x-admin.layout.sections.form-label inpName="password" title="Senha do Usuário">
                    <x-admin.layout.sections.form-input inpName="password" type="password" placeholder="••••••••"
                        required ::disabled="{{ $item->id ? '!changePass ? true : false' : 'false' }}" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="password_confirmation" title="Confirme a Senha do Usuário">
                    <x-admin.layout.sections.form-input inpName="password_confirmation" type="password"
                        placeholder="••••••••" required ::disabled="{{ $item->id ? '!changePass ? true : false' : 'false' }}" />
                </x-admin.layout.sections.form-label>
            </x-admin.layout.sections.form-grid>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
