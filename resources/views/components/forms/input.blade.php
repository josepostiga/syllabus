@props(['disabled' => false, 'id' => '', 'name', 'value' => ''])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}
       id="{{ empty($id) ? $name : $id}}"
       name="{{ $name }}"
       value="{{ old($id, $value) }}">
