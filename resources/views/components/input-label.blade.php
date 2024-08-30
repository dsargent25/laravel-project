@props(['value'])

<label style="color:rgb(38, 167, 222)" {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
