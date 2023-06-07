<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Contatos >
            <x-admin.layout.sections.page-subtitle>
                Visualizar
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
        <x-admin.layout.sections.page-button :href="route('admin.contacts.index')">
            Listar Contatos
        </x-admin.layout.sections.page-button>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form-grid class="p-6 bg-white shadow-sm sm:rounded-lg" gridCols="sm:grid-cols-2">
            <x-admin.layout.sections.form-label inpName="name" title="Nome">
                <x-admin.layout.sections.form-input inpName="name" :inpValue="$item->name" readonly />
            </x-admin.layout.sections.form-label>
            <x-admin.layout.sections.form-label inpName="email" title="E-mail">
                <x-admin.layout.sections.form-input inpName="email" :inpValue="$item->email" readonly />
            </x-admin.layout.sections.form-label>
            <x-admin.layout.sections.form-label inpName="subject" title="Assunto">
                <x-admin.layout.sections.form-input inpName="subject" :inpValue="$item->subject" readonly />
            </x-admin.layout.sections.form-label>
            <x-admin.layout.sections.form-label inpName="phone" title="Telefone">
                <x-admin.layout.sections.form-input inpName="phone" :inpValue="$item->phone" readonly />
            </x-admin.layout.sections.form-label>
            <x-admin.layout.sections.form-textarea inpName="message" title="Mensagem" :inpValue="$item->message"
                class="sm:col-span-2" readonly />
        </x-admin.layout.sections.form-grid>
    </x-admin.layout.sections.list-section>
</x-admin.layout.app>
