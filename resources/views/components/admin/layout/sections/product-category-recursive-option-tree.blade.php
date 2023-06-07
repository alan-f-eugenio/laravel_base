@props(['categories', 'idSelected' => null, 'inpName', 'treeStr' => ''])


@foreach ($categories as $category)
    @php
        $treeStr = $treeStr . ($category->id_parent ? ' > ' : '') . $category->name;
    @endphp
    <x-admin.layout.sections.form-select-option :inpValue="$category->id" :title="$treeStr" />
    @if ($category->allChilds())
        <x-admin.layout.sections.product-category-recursive-option-tree :treeStr="$treeStr" :inpName="$inpName"
            :categories="$category->allChilds" />
    @endif
@endforeach
