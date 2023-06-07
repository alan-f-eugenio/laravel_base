<x-public.layout.app>
    <div class="p-6 space-y-6 bg-white border shadow-sm sm:rounded-lg">
        <x-admin.layout.sections.list-section>
            <x-admin.layout.sections.form :action="route('customer_password.update')" :editing="true">
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-2">
                    <x-admin.layout.sections.form-subtitle>Alterar Senha
                    </x-admin.layout.sections.form-subtitle>
                    <x-admin.layout.sections.form-label inpName="current_password" title="Senha Atual">
                        <x-admin.layout.sections.form-input inpName="current_password" type="password"
                            placeholder="••••••••" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
                <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-2">
                    <x-admin.layout.sections.form-label inpName="password" title="Nova Senha">
                        <x-admin.layout.sections.form-input inpName="password" type="password" placeholder="••••••••"
                            required />
                    </x-admin.layout.sections.form-label>
                    <x-admin.layout.sections.form-label inpName="password_confirmation" title="Confirme a Nova Senha">
                        <x-admin.layout.sections.form-input inpName="password_confirmation" type="password"
                            placeholder="••••••••" required />
                    </x-admin.layout.sections.form-label>
                </x-admin.layout.sections.form-grid>
            </x-admin.layout.sections.form>
        </x-admin.layout.sections.list-section>
    </div>
</x-public.layout.app>
