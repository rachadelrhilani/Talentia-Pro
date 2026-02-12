



const conv = document.getElementById('messages');
if (conv) {
    const conversationId = conv.dataset.conversationId;
    window.Echo.private(`conversation.${conversationId}`)
    .listen('MessageSent',(event)=> {
    console.log(event)

    const div = document.createElement('div');
    div.classList = 'justify-start flex ';
    div.innerHTML = `<div class="bg-slate-100 text-slate-900 max-w-[70%] rounded-2xl px-4 py-2">
                        <p class="text-sm">${event.message.text}</p>
                        <p class="mt-1 text-[11px] {{ $isMine ? 'text-blue-100' : 'text-slate-500' }}">
                           ${event.message.sender.name} · ${event.message.created_at}
                        </p>
                    </div>`;
        conv.append(div);
        conv.scrollTop = conv.scrollHeight;

    });

    conv.scrollTop = conv.scrollHeight;
}
