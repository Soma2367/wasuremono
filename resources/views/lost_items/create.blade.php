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

    <div class="max-w-3xl mx-auto mt-24 px-6 py-10 bg-white shadow-md rounded-lg">
        <form action="{{ route('lost_items.store') }}" method="POST">

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
            </div>

            <div class="mt-8">
                <x-button class="w-full justify-center">
                    登録する
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
