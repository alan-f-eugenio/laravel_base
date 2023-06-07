@props(['categories', 'idSelected' => null, 'inpName', 'count' => 1, 'treeList' => []])

@php
    $levelStr = '';
    for ($x = 0; $x < $count; $x++) {
        $levelStr .= '-';
    }
    $levelStr .= ' ';
    $count++;
@endphp

@foreach ($categories as $category)
    <x-admin.layout.sections.form-select-option :inpValue="$category->id" :title="$levelStr . $category->name" :selected="(old($inpName) ?: $idSelected) == $category->id"
        :disabled="in_array($category->id, $treeList)" />
    @if ($category->allChilds())
        <x-admin.layout.sections.product-category-recursive-option :categories="$category->allChilds" :idSelected="$idSelected" :treeList="$treeList"
            :count="$count" :inpName="$inpName" />
    @endif
@endforeach
