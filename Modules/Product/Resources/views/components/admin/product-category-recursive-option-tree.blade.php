@props(['categories', 'idSelected' => null, 'inpName', 'treeStr' => ''])


@foreach ($categories as $category)
    @php
        $treeStr = $treeStr . ($category->id_parent ? ' > ' : '') . $category->name;
    @endphp
    <x-admin.form-select-option :inpValue="$category->id" :title="$treeStr" />
    @if ($category->allChilds())
        <x-product::admin.product-category-recursive-option-tree :treeStr="$treeStr" :inpName="$inpName"
            :categories="$category->allChilds" />
    @endif
@endforeach
