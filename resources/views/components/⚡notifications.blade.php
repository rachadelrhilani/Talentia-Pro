<?php

use Livewire\Component;
use \Illuminate\Support\Facades\Auth;
new class extends Component
{
    public $notifications = [];

    public function mount()
    {
        $user = auth()->user();
        $this->notifications = $user
            ? $user->notifications()->latest()->take(10)->get()
            : collect();
    }

    public function markAsRead(){
      auth()::user()->unreadNotifications->markAsRead();
       $this->mount();
    }
};
?>

<div>
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
<script>
    document.addEventListener('user-click-notify', ()=>{
        Livewire.dispatchTo('notifications','markAsRead')
    })
</script>
