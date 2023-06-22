<x-public-layout>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.list-section>
            <x-admin.form :action="route('customer_password.update')" :editing="true">
                <x-admin.form-grid gridCols="sm:grid-cols-2">
                    <x-admin.form-subtitle>Alterar Senha
                    </x-admin.form-subtitle>
                    <x-admin.form-label inpName="current_password" title="Senha Atual">
                        <x-admin.form-input inpName="current_password" type="password"
                            placeholder="••••••••" required />
                    </x-admin.form-label>
                </x-admin.form-grid>
                <x-admin.form-grid gridCols="sm:grid-cols-2">
                    <x-admin.form-label inpName="password" title="Nova Senha">
                        <x-admin.form-input inpName="password" type="password" placeholder="••••••••"
                            required />
                    </x-admin.form-label>
                    <x-admin.form-label inpName="password_confirmation" title="Confirme a Nova Senha">
                        <x-admin.form-input inpName="password_confirmation" type="password"
                            placeholder="••••••••" required />
                    </x-admin.form-label>
                </x-admin.form-grid>
            </x-admin.form>
        </x-admin.list-section>
    </div>
</x-public-layout>
