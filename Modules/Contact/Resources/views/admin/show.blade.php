<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-title>
            Contatos >
            <x-admin.page-subtitle>
                Visualizar
            </x-admin.page-subtitle>
        </x-admin.page-title>
        <x-admin.page-button :href="route('admin.contacts.index')">
            Listar Contatos
        </x-admin.page-button>
    </x-slot>
    <x-admin.list-section>
        <x-admin.form-grid class="p-6 bg-white shadow-sm sm:rounded-lg" gridCols="sm:grid-cols-2">
            <x-admin.form-label inpName="name" title="Nome">
                <x-admin.form-input inpName="name" :inpValue="$item->name" readonly />
            </x-admin.form-label>
            <x-admin.form-label inpName="email" title="E-mail">
                <x-admin.form-input inpName="email" :inpValue="$item->email" readonly />
            </x-admin.form-label>
            <x-admin.form-label inpName="subject" title="Assunto">
                <x-admin.form-input inpName="subject" :inpValue="$item->subject" readonly />
            </x-admin.form-label>
            <x-admin.form-label inpName="phone" title="Telefone">
                <x-admin.form-input inpName="phone" :inpValue="$item->phone" readonly />
            </x-admin.form-label>
            <x-admin.form-textarea inpName="message" title="Mensagem" :inpValue="$item->message"
                class="sm:col-span-2" readonly />
        </x-admin.form-grid>
    </x-admin.list-section>
</x-admin-layout>
