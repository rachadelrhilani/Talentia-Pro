<?php

use Livewire\Component;

new class extends Component
{
    public $notifications = [];
    public $unreadCount = 0;
    public $open = false;

    public function mount()
    {
        $user = auth()->user();
        if (! $user) {
            $this->notifications = collect();
            $this->unreadCount = 0;
            return;
        }

        $this->notifications = $user->notifications()->latest()->take(10)->get();
        $this->unreadCount = $user->unreadNotifications()->count();
    }

    public function togglePanel()
    {
        $this->open = !$this->open; //flip

        if ($this->open) {
            $this->markAsRead();
        }
    }

    public function justCloseIt(){
        $this->open = false;
    }

    public function markAsRead()
    {
        $user = auth()->user();
        if (! $user) {
            return;
        }

        $user->unreadNotifications->markAsRead();
        $this->unreadCount = 0;
        $this->notifications = $user->notifications()->latest()->take(10)->get();
    }
};
?>

<div class="relative">
    <button type="button" id="notifications-button" wire:click="togglePanel"
        class="flex flex-col items-center text-gray-600 hover:text-black transition relative">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
            viewBox="0 0 24 24">
            <path d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2zm6-6V11a6 6 0 0 0-5-5.91V4a1 1 0 1 0-2 0v1.09A6 6 0 0 0 6 11v5l-2 2v1h16v-1l-2-2z" />
        </svg>
        <span id="notifications-badge"
            class="absolute -top-1 -right-1 min-w-5 h-5 px-1.5 rounded-full bg-red-500 text-white text-[10px] leading-5 text-center font-semibold {{ $unreadCount < 1 ? 'hidden' : '' }}">
            {{ $unreadCount }}
        </span>
        <span class="text-[11px] hidden md:block">Notification</span>
    </button>
    <div id="notifications-panel" wire:click.outside="justCloseIt"
        class="absolute right-0 top-10 w-80 bg-white shadow-lg rounded-lg border border-gray-100 {{ $open ? '' : 'hidden' }}">
        <div class="px-4 py-3 border-b border-gray-100 text-sm font-semibold text-gray-700">
            Notifications
        </div>
        <div id="Ncontainer" class="max-h-80 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 flex gap-3 hover:bg-gray-50 transition">
                    <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold">
                        {{ strtoupper(substr($notification->data['message'] ?? 'N', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="text-sm text-gray-800">
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ optional($notification->created_at)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-6 text-sm text-gray-500 text-center">
                    Aucune notification.
                </div>
            @endforelse
        </div>
    </div>
</div>
