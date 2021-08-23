@props(['disabled' => false, 'id' => '', 'name', 'value'])

<label {{ $attributes }}>
  <input {{ $disabled ? 'disabled' : '' }} {{ old($name) ? 'checked' : '' }}
         class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
         type="checkbox"
         id="{{ empty($id) ? $name : $id}}"
         name="{{ $name }}">
  <span class="ml-2 text-sm text-gray-600">{{ $value }}</span>
</label>
