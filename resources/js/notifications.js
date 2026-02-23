const menu = document.getElementById("menu");
const userId = menu ? menu.dataset.userId : null;

// Helper: show the notification badge
function showNotificationBadge() {
    const badge = document.getElementById("notifications-badge");
    if (badge) {
        badge.classList.remove("hidden");
    }
}

// Helper: prepend a notification item to the panel
function prependNotificationItem(message) {
    const container = document.getElementById("Ncontainer");
    if (!container) return;

    // Remove the "Aucune notification" placeholder if present
    const empty = container.querySelector(".text-gray-500.text-center");
    if (empty) empty.closest("div")?.remove();

    const div = document.createElement("div");
    div.className = "px-4 py-3.5 flex gap-3 hover:bg-gray-50 transition";
    div.innerHTML = `
        <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold shrink-0">
            ${(message || "N")[0].toUpperCase()}
        </div>
        <div class="flex-1 min-w-0">
            <div class="text-sm text-gray-800 leading-5">${message || "Notification"}</div>
            <div class="text-xs text-gray-500 mt-1">À l'instant</div>
        </div>
    `;
    container.prepend(div);
}

// Listen for Echo notifications (real-time from Reverb)
if (userId) {
    window.Echo.private(`App.Models.User.${userId}`).notification(
        (notification) => {
            console.log("Echo notification received:", notification);
            showNotificationBadge();
            prependNotificationItem(notification.message);

            // Trigger Livewire refresh
            if (window.Livewire) {
                window.Livewire.dispatch("echo-notification-received", {
                    notification: notification,
                });
            }
        },
    );
}

// Listen for Livewire's dispatched JS event (backup channel via Livewire re-render)
document.addEventListener("notification-received", () => {
    console.log("Livewire notification-received event fired");
    showNotificationBadge();
});
