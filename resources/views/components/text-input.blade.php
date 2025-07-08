@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-200 dark:bg-pink-200 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-pink-500 dark:focus:ring-pink-600 rounded-md shadow-sm']) }}>
