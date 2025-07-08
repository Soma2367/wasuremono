<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一覧表示
        </h2>
    </x-slot>

    <a href="{{ route('lost_items.create') }}"
       class="fixed bottom-8 right-8 z-50 flex items-center justify-center w-16 h-16 bg-indigo-400 rounded-full shadow-2xl hover:bg-indigo-600 transition transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-indigo-300"
       title="add-lost-items" aria-label="add">
        <x-heroicon-o-plus class="w-8 h-8 text-white" />
    </a>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-16">
        @foreach ($lost_items as $lost_item)
            <div class="overflow-hidden rounded-xl bg-white shadow-md flex flex-col h-full relative">
                <div class="p-4">
                    <div class="swiper w-full aspect-square rounded-lg overflow-hidden">
                        <div class="swiper-wrapper">
                            @foreach([1, 2, 3] as $i)
                                @php
                                    $photo = $lost_item->{'photo'.$i};
                                @endphp
                                <div class="swiper-slide flex items-center justify-center bg-gray-100">
                                    @if($photo)
                                        <img src="{{ asset('storage/' . $photo) }}" alt="画像{{ $i }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <img src="{{ asset('storage/noimage/img.png') }}" alt="ダミー画像" class="w-full h-full object-cover rounded-lg opacity-60">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <div class="flex items-center mb-4">
                        <span class="inline-block mr-2 text-indigo-500">
                            <x-heroicon-o-stop class="h-6 w-6 text-indigo-500" />
                        </span>
                        <div class="flex justify-between items-center w-full">
                            <div class="text-2xl font-extrabold text-gray-900 tracking-tight leading-tight">
                                {{ $lost_item->lost_item_name }}
                            </div>
                            <div class="flex space-x-3 ml-4">
                                <button class="p-2 bg-white rounded-full shadow-md border border-blue-200 hover:bg-blue-100 hover:scale-110 transition focus:outline-none focus:ring-2 focus:ring-blue-300" title="編集" aria-label="編集">
                                    <x-heroicon-o-pencil class="w-6 h-6 text-blue-500" />
                                </button>
                                <button class="p-2 bg-white rounded-full shadow-md border border-red-200 hover:bg-red-100 hover:scale-110 transition focus:outline-none focus:ring-2 focus:ring-red-300" title="削除" aria-label="削除">
                                    <x-heroicon-o-trash class="w-6 h-6 text-red-500" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4 border-gray-200">
                    <div class="space-y-3 flex-1">
                        <div class="flex items-center">
                            <span class="text-gray-500 font-medium w-24">場所</span>
                            <span class="text-gray-900 font-semibold text-lg">{{ $lost_item->place }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-500 font-medium w-24">日付</span>
                            <span class="text-gray-900 font-semibold text-lg">{{ $lost_item->created_at->format('Y/m/d') }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-500 font-medium w-24">見つけた人</span>
                            <span class="text-gray-900 font-semibold text-lg">{{ $lost_item->finder_name }}</span>
                        </div>
                    </div>
                    @if($lost_item->description)
                    <div class="mt-6 bg-indigo-50 border border-indigo-100 rounded-lg py-4 px-3">
                        <div class="text-indigo-600 font-semibold mb-1">備考</div>
                        <div class="text-gray-700 text-base leading-relaxed">{{ $lost_item->description }}</div>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
</x-app-layout>