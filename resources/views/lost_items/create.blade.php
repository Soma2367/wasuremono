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
        <form action="{{ route('lost_items.store') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <div class="grid gap-6">
                {{-- 忘れ物名 --}}
                <div>
                    <label for="lost_item_name" class="block font-semibold text-gray-700">忘れ物名</label>
                    <x-input-error :messages="$errors->get('lost_item_name')" class="my-2"/>
                    <input type="text" name="lost_item_name" id="lost_item_name"
                        class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                        placeholder="例：スマートフォン" value="{{ old('lost_item_name')  }}">
                </div>

                {{-- 画像3枚 --}}
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">忘れ物画像(最大3枚)</label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @for($i = 0; $i < 3; $i++)
                        <div class="relative group border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50 hover:bg-indigo-50 transition-all duration-200 shadow-sm">
                            <label id="upload-label-{{ $i }}" for="photo{{ $i }}" class="flex flex-col items-center justify-center h-40 cursor-pointer text-gray-500 hover:text-indigo-600 transition">
                                <x-heroicon-o-arrow-down-tray id="icon-default-{{ $i }}"
                                                              class="w-10 h-10 mb-2 group-hover:scale-110 transition-transform duration-200" />
                                 <span class="text-sm font-medium">画像{{ $i + 1 }}を選択</span>
                            </label>
                            <input type="file" name="photos[]" accept="image/*"
                                   class="absolute inset-0 opacity-0 cursor-pointer"
                                   data-index="{{ $i }}" onchange="previewImg(this)">
                                   <img id="preview-img-{{ $i }}" 
                                        src="#" 
                                        alt="img" 
                                        class="absolute inset-0 w-full h-full object-cover rounded-xl hidden">
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
                        placeholder="例：フロントデスク" value="{{ old('place')  }}">
                </div>

                {{-- 発見者 --}}
                <div>
                    <label for="finder_name" class="block font-semibold text-gray-700">発見者</label>
                    <x-input-error :messages="$errors->get('finder_name')" class="my-2"/>
                    <input type="text" name="finder_name" id="finder_name"
                        class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="例：山田太郎" value="{{ old('finder_name')  }}">
                </div>

                {{-- 備考 --}}
                <div>
                    <label for="description" class="block font-semibold text-gray-700">備考</label>
                    <x-input-error :messages="$errors->get('description')" class="my-2" />
                    <textarea name="description" id="description"
                         class="mt-2 w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                         placeholder="備考">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-8">
                <x-primary-button class="w-full justify-center">
                    登録する
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
    function previewImg(input) {
        const index = input.dataset.index;
        const file = input.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImg = document.getElementById('preview-img-' + index);
            const label = document.getElementById('upload-label-' + index);

            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (label) label.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    }
</script>
</x-app-layout>
