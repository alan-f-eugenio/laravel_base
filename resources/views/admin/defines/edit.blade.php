<x-admin.layout.app>
    <x-slot name="header">
        <x-admin.layout.sections.page-title>
            Definições >
            <x-admin.layout.sections.page-subtitle>
                Alterar
            </x-admin.layout.sections.page-subtitle>
        </x-admin.layout.sections.page-title>
    </x-slot>
    <x-admin.layout.sections.list-section>
        <x-admin.layout.sections.form :action="route('admin.defines.update')" :editing="true">
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                <x-admin.layout.sections.form-subtitle>Otimização (SEO)</x-admin.layout.sections.form-subtitle>
                <x-admin.layout.sections.form-label inpName="page_title" title="Título da Página">
                    <x-admin.layout.sections.form-input inpName="page_title" placeholder="Page title" :inpValue="old('page_title') ?: $item->page_title"
                        required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="page_meta_keywords" title="Palavras Chave (SEO)">
                    <x-admin.layout.sections.form-input inpName="page_meta_keywords" placeholder="Meta keywords"
                        :inpValue="old('page_meta_keywords') ?: $item->page_meta_keywords" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="page_meta_description" title="Meta Descrição (SEO)">
                    <x-admin.layout.sections.form-input inpName="page_meta_description" title="Meta Descrição (SEO)"
                        placeholder="Meta description" :inpValue="old('page_meta_description') ?: $item->page_meta_description" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-subtitle>Dados da Empresa</x-admin.layout.sections.form-subtitle>
                <x-admin.layout.sections.form-label inpName="company_name" title="Nome da Empresa">
                    <x-admin.layout.sections.form-input inpName="company_name" placeholder="Nome da empresa"
                        :inpValue="old('company_name') ?: $item->company_name" required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_corporate_name" title="Razão social">
                    <x-admin.layout.sections.form-input inpName="company_corporate_name" placeholder="Razão social"
                        :inpValue="old('company_corporate_name') ?: $item->company_corporate_name" required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_cnpj" title="CNPJ da Empresa">
                    <x-admin.layout.sections.form-input inpName="company_cnpj" placeholder="00.000.000/0000-00"
                        :inpValue="old('company_cnpj') ?: $item->company_cnpj" required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_email" title="E-mail do site">
                    <x-admin.layout.sections.form-input inpName="company_email" type="email"
                        placeholder="E-mail do site" :inpValue="old('company_email') ?: $item->company_email" required />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_cep" title="CEP (Para Cálculo de Frete)">
                    <x-admin.layout.sections.form-input inpName="company_cep" placeholder="00000-000" :inpValue="old('company_cep') ?: $item->company_cep"
                        required />
                </x-admin.layout.sections.form-label>
            </x-admin.layout.sections.form-grid>
            <x-admin.layout.sections.form-textarea inpName="company_address" title="Endereço da Empresa"
                placeholder="Endereço da empresa" :inpValue="old('company_address') ?: $item->company_address" />
            <x-admin.layout.sections.form-grid gridCols="sm:grid-cols-3">
                <x-admin.layout.sections.form-subtitle>Contatos e Redes Sociais</x-admin.layout.sections.form-subtitle>
                <x-admin.layout.sections.form-label inpName="company_phone" title="Telefone/Celular">
                    <x-admin.layout.sections.form-input class="maskPhone" inpName="company_phone"
                        placeholder="(00) 0000-0000" :inpValue="old('company_phone') ?: $item->company_phone" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_whats" title="WhatsApp">
                    <x-admin.layout.sections.form-input class="maskPhone" inpName="company_whats"
                        placeholder="(00) 00000-0000" :inpValue="old('company_whats') ?: $item->company_whats" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_opening_hours" title="Horário de Atendimento">
                    <x-admin.layout.sections.form-input inpName="company_opening_hours"
                        placeholder="Horário de Atendimento" :inpValue="old('company_opening_hours') ?: $item->company_opening_hours" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_face" title="URL do Facebook">
                    <x-admin.layout.sections.form-input inpName="company_face" placeholder="URL do Facebook"
                        :inpValue="old('company_face') ?: $item->company_face" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_insta" title="URL do Instagram">
                    <x-admin.layout.sections.form-input inpName="company_insta" placeholder="URL do Instagram"
                        :inpValue="old('company_insta') ?: $item->company_insta" />
                </x-admin.layout.sections.form-label>
                <x-admin.layout.sections.form-label inpName="company_yout" title="URL do Youtube">
                    <x-admin.layout.sections.form-input inpName="company_yout" placeholder="URL do Youtube"
                        :inpValue="old('company_yout') ?: $item->company_yout" />
                </x-admin.layout.sections.form-label>
            </x-admin.layout.sections.form-grid>
        </x-admin.layout.sections.form>
    </x-admin.layout.sections.list-section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Inputmask({
                mask: "99.999.999/9999-99",
            }).mask(document.querySelectorAll("#company_cnpj"))
            Inputmask({
                mask: "99999-999",
            }).mask(document.querySelectorAll("#company_cep"))
            Inputmask({
                mask: "((99) 9999-9999)|((99) 99999-9999)",
                greedy: false,
            }).mask(document.querySelectorAll("#company_phone"))
            Inputmask({
                mask: "(99) 99999-9999",
            }).mask(document.querySelectorAll("#company_whats"))
        })
    </script>
</x-admin.layout.app>
