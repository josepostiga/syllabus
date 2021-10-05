@props(['disabled' => false, 'options' => [], 'name', 'selected' => ''])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}
        id="{{ empty($id) ? $name : $id}}"
        name="{{ $name }}"
>
  @foreach($options as $index => $option)
    <option value="{{ $index }}" @if($selected === $index) selected @endif>{{ $option }}</option>
  @endforeach
</select>
