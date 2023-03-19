<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        ホーム
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex flex-wrap">
            @foreach($products as $product)
              <div class="w-1/4 p-2 md:p-4 mt-2">
                {{-- <a href="{{ route('owner.products.edit', ['product' => $product->id]) }}"> --}}
                  <div class="border rounded-md p-2 md:p-4">
                    <div class="mb-4">
                      <div>
                        <x-thumbnail filename="{{ $product->imageFirst->filename ?? '' }}" type="products" />
                        <div class="text-gray-700">
                          {{ $product->name }}
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
