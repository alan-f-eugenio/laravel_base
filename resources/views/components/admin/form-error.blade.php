@props(['inpName'])
@error($inpName)
    <label class="text-red-500">
        {{ $message }}
    </label>
@enderror
