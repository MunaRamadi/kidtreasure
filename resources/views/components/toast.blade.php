<div 
    x-data="{ show: false, title: '', message: '', type: 'success' }"
    x-show="show"
    x-init="
        $el.style.display = 'none';
        window.showToast = (title, message, type = 'success') => {
            $data.type = type.toLowerCase();
            $data.title = title;
            $data.message = message;
            $data.show = true;
            setTimeout(() => { $data.show = false }, 3000);
        }
    "
    @toast.window="
        showToast($event.detail.title, $event.detail.message, $event.detail.type);
    "
    style="display: none;"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed bottom-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg flex items-center"
    :class="{
        'bg-green-500 text-white': type === 'success',
        'bg-red-500 text-white': type === 'error',
        'bg-blue-500 text-white': type === 'info',
        'bg-yellow-500 text-white': type === 'warning'
    }"
>
    <div class="mr-3">
        <template x-if="type === 'success'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </template>
        <template x-if="type === 'error'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </template>
        <template x-if="type === 'info'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </template>
        <template x-if="type === 'warning'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </template>
    </div>
    <div>
        <div x-text="title" class="font-bold"></div>
        <div x-text="message"></div>
    </div>
    <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>
