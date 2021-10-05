@props(['headers'])

<table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
  <thead class="bg-gray-50">
  <tr>
    @foreach ($headers as $header)
      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        {{ $header }}
      </th>
    @endforeach
    <th scope="col" class="relative px-6 py-3"></th>
  </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
  {{ $slot }}
  </tbody>
</table>
