<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Pengaturan Aplikasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            @foreach($settings as $group => $groupSettings)
                            <div class="border rounded-lg p-6">
                                <h3 class="text-lg font-semibold mb-4 capitalize">
                                    {{ str_replace('_', ' ', $group) }}
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($groupSettings as $setting)
                                    <div>
                                        <label for="setting-{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $setting->description }}
                                        </label>
                                        
                                        @if($setting->type === 'boolean')
                                        <select name="settings[{{ $setting->key }}]" id="setting-{{ $setting->key }}" 
                                                class="w-full border-gray-300 rounded-md shadow-sm">
                                            <option value="1" {{ $setting->value ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ !$setting->value ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                        @elseif($setting->type === 'json')
                                        <textarea name="settings[{{ $setting->key }}]" id="setting-{{ $setting->key }}"
                                                rows="4" class="w-full border-gray-300 rounded-md shadow-sm"
                                                placeholder="{{ $setting->description }}">{{ $setting->value }}</textarea>
                                        @else
                                        <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}" 
                                               name="settings[{{ $setting->key }}]" 
                                               id="setting-{{ $setting->key }}"
                                               value="{{ $setting->value }}"
                                               class="w-full border-gray-300 rounded-md shadow-sm"
                                               placeholder="{{ $setting->description }}">
                                        @endif
                                        
                                        <p class="text-xs text-gray-500 mt-1">Key: <code>{{ $setting->key }}</code></p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>