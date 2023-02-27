@props(['status' => 'info'])
@php
  if ($status === 'info') $bgColor = 'bg-blue-300';
  if ($status === 'alert') $bgColor = 'bg-red-500';
@endphp
@if(session('message'))
  <div x-data="flashMessage" class="absolute w-2/3 top-0 left-1/2 -translate-x-1/2">
    <template x-if="isShow">
      <div class="{{ $bgColor }} mx-auto p-2 text-white flex flex-row justify-between items-center">
        <div class="ml-4">{{ session('message') }}</div>
        <div x-on:click="clickClose()" class="text-2xl mr-4 hover:cursor-pointer">×</div>
      </div>
    </template>
  </div>
@endif

<script>
  function flashMessage() {
    return {
      isShow: true,
      clickClose() {
        this.isShow = false;
      }
    }
  }

</script>