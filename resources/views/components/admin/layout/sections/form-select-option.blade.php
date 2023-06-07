@props(['inpValue', 'title', 'selected' => false, 'disabled' => false])
<option style="{{ $selected ? 'font-weight: 600' : '' }}" @selected($selected) @disabled($disabled)
    value="{{ $inpValue }}">{{ $title }}</option>
