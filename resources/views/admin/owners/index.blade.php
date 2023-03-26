<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="md:p-6 text-gray-900">
            <section class="text-gray-600 body-font">
              <div class="container px-5 mx-auto relative">
                <x-flash-message :status="session('status')" />
                <div class="flex justify-end">
                  <a href="{{ route('admin.owners.create') }}" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録</a>
                </div>
                <div class="lg:w-2/3 w-full mx-auto overflow-auto mt-4">
                  <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                      <tr>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">作成日</th>
                        <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($owners as $owner)
                        <tr>
                          <td class="md:px-4 py-3">{{ $owner->name }}</td>
                          <td class="md:px-4 py-3">{{ $owner->email }}</td>
                          <td class="px-4 py-3">{{ $owner->created_at->diffForHumans() }}</td>
                          <td class="md:px-4 py-3">
                            <div class="flex justify-around" x-data="deleteAction">
                              <a href="{{ route('admin.owners.edit', ['owner' => $owner->id]) }}" class="text-white bg-green-500 border-0 py-1 px-4 focus:outline-none hover:bg-green-600 rounded text-center">編集</a>
                              <a href="#" form="delete-action_{{ $owner->id }}" x-on:click.prevent="deleteClick({{ $owner->id }})" class="text-white bg-red-500 border-0 py-1 px-4 focus:outline-none hover:bg-red-600 rounded text-center">削除</a>
                            </div>
                          </td>
                          <form id="delete-action_{{ $owner->id }}" method="POST" action="{{route('admin.owners.destroy', ['owner' => $owner->id])}}">
                            @csrf
                            @method('delete')
                          </form>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="mt-2">
                    {{ $owners->links() }}
                  </div>
                </div>
              </div>
            </section>
          </div>
      </div>
    </div>
  </div>
  <script>
    function deleteAction(){
      return {
        deleteClick(id){
          console.log(id)
          if (confirm("本当に削除してもよろしいですか？")){
            document.querySelector(`#delete-action_${id}`).submit();
          }
        }
      }
    }
  </script>
</x-app-layout>
