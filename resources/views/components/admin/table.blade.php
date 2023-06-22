@props(['collection', 'ths' => null, 'tbody', 'tfoot' => null, 'sortable' => false, 'tableOnly' => false, 'fixed' => false])

@if (!$tableOnly)
    <div class="w-full overflow-x-auto bg-white shadow-md sm:rounded-lg">
@endif
<table class="w-full text-sm text-left text-gray-500">
    @if ($ths)
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                {{ $ths }}
            </tr>
        </thead>
    @endif
    <tbody @class(['table-sortable' => $sortable])>
        {{ $tbody }}
    </tbody>
    @if ($tfoot)
        <tfoot>
            {{ $tfoot }}
        </tfoot>
    @elseif (method_exists($collection, 'hasPages'))
        <tfoot>
            <tr>
                <td class="px-6 py-4" colspan="99">
                    {{ $collection->links() }}
                </td>
            </tr>
        </tfoot>
    @endif
</table>
@if (!$tableOnly)
    </div>
@endif
