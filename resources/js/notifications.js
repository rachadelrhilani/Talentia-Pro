const menu = document.getElementById('menu');
const userId = menu.dataset.userId;

if (userId) {
    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            console.log(notification);
            const div = document.createElement('div');
            div.classList = "px-4 py-3 flex gap-3 hover:bg-gray-50 transition"
            div.innerHTML = `
                                <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-semibold">
                                    ${notification.message[0]}
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-800">
                                       ${notification.message}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">${notification.time}</div>
                                </div>

`;
            document.getElementById('Ncontainer').prepend(div);
        });
}
