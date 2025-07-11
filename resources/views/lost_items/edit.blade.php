<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            忘れ物登録
        </h2>
    </x-slot>
    @if(session('message'))
      <div class="text-green-600 font-bold">
       {{session('message')}}
      </div>
    @endif

    <div class="max-w-4xl mx-auto mt-12 px-6 py-10 bg-white shadow-md rounded-lg">
        <form action="{{ route('lost_items.update', $lost_item) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('patch')
            <div class="grid gap-6">
                {{-- 忘れ物名 --}}
                <div>
                    <label for="lost_item_name" class="block font-semibold text-gray-700">忘れ物名</label>
                    <x-input-error :messages="$errors->get('lost_item_name')" class="my-2"/>
                    <input type="text" name="lost_item_name" id="lost_item_name"
                        class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="例：スマートフォン" value="{{ old('lost_item_name', $lost_item->lost_item_name)  }}">
                </div>

                {{-- 画像3枚 --}}
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">忘れ物画像(最大3枚)</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @for($i = 0; $i < 3; $i++)
                            @php
                                $photoField = 'photo' . ($i + 1);
                                $currentPhotoPath = $lost_item->$photoField; 
                                $displayPhotoPath = $currentPhotoPath
                                    ? asset('storage/' . $currentPhotoPath)
                                    : asset('storage/noimage/img.png');
                            @endphp
                            <div class="relative group border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50 hover:bg-indigo-50 transition-all duration-200 shadow-sm">
                                <label id="upload-label-{{ $i }}" for="photo{{ $i }}" class="flex flex-col items-center justify-center h-40 cursor-pointer text-gray-500 hover:text-indigo-600 transition {{ $currentPhotoPath ? 'hidden' : '' }}">
                                    <x-heroicon-o-arrow-down-tray id="icon-default-{{ $i }}"
                                                                  class="w-10 h-10 mb-2 group-hover:scale-110 transition-transform duration-200" />
                                    <span class="text-sm font-medium">画像{{ $i + 1 }}を選択</span>
                                </label>
                                <input type="file" name="photos[{{ $i }}]" accept="image/*"
                                       class="absolute inset-0 opacity-0 cursor-pointer"
                                       data-index="{{ $i }}" onchange="previewImg(this)">
                                <img id="preview-img-{{ $i }}"
                                     src="{{ $displayPhotoPath }}"
                                     alt="img"
                                     class="absolute inset-0 w-full h-full object-cover rounded-xl {{ $currentPhotoPath ? '' : 'hidden' }}">
                                @if($currentPhotoPath) 
                                    <button type="button"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 text-xs opacity-75 hover:opacity-100 transition-opacity delete-photo-btn"
                                            data-index="{{ $i }}"
                                            data-default-img="{{ asset('storage/noimage/img.png') }}"> 
                                        <x-heroicon-o-x-mark class="w-4 h-4" />
                                    </button>
                                @endif

                                <input type="hidden" name="delete_photos[{{ $i }}]" id="delete-photo-{{ $i }}" value="0">
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- 発見場所 --}}
                <div>
                    <label for="place" class="block font-semibold text-gray-700">発見場所</label>
                    <x-input-error :messages="$errors->get('place')" class="my-2"/>
                    <input type="text" name="place" id="place"
                        class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="例：フロントデスク" value="{{ old('place', $lost_item->place)  }}">
                </div>

                {{-- 発見者 --}}
                <div>
                    <label for="finder_name" class="block font-semibold text-gray-700">発見者</label>
                    <x-input-error :messages="$errors->get('finder_name')" class="my-2"/>
                    <input type="text" name="finder_name" id="finder_name"
                        class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="例：山田太郎" value="{{ old('finder_name', $lost_item->finder_name)  }}">
                </div>

                {{-- 備考 --}}
                <div>
                    <label for="description" class="block font-semibold text-gray-700">備考</label>
                    <x-input-error :messages="$errors->get('description')" class="my-2" />
                    <textarea name="description" id="description"
                         class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                         placeholder="備考">{{ old('description', $lost_item->description) }}</textarea>
                </div>
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full justify-center">
                    更新する
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
    const defaultNoImage = '{{ asset('storage/noimage/img.png') }}';

    function previewImg(input) {
        const index = input.dataset.index;
        const file = input.files[0];
        const previewImg = document.getElementById('preview-img-' + index);
        const label = document.getElementById('upload-label-' + index);
        const deleteBtn = previewImg.nextElementSibling; 
        const deleteHiddenInput = document.getElementById('delete-photo-' + index);

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            label.classList.add('hidden');
            if (deleteBtn && deleteBtn.classList.contains('delete-photo-btn')) { 
                deleteBtn.classList.remove('hidden'); 
            }
            deleteHiddenInput.value = '0'; 
        };

        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-photo-btn').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.dataset.index;
                const defaultImg = this.dataset.defaultImg;
                const previewImg = document.getElementById('preview-img-' + index);
                const label = document.getElementById('upload-label-' + index);
                const fileInput = document.querySelector(`input[name="photos[${index}]"]`);
                const deleteHiddenInput = document.getElementById('delete-photo-' + index);

                previewImg.src = defaultImg;
                previewImg.classList.add('hidden'); 
                label.classList.remove('hidden'); 

                if (fileInput) {
                    fileInput.value = ''; 
                }

                this.classList.add('hidden');

                deleteHiddenInput.value = '1';
            });
        });
    });
    </script>
</x-app-layout>