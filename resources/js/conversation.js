const conv = document.getElementById("messages");
if (conv) {
    const conversationId = conv.dataset.conversationId;
    window.Echo.private(`conversation.${conversationId}`).listen(
        "MessageSent",
        (event) => {
            console.log(event);

            const div = document.createElement("div");
            div.classList = "justify-start flex ";

            let attachmentHtml = "";
            if (event.message.attachment_path) {
                const type = event.message.attachment_type.toLowerCase();
                if (["jpg", "jpeg", "png", "gif"].includes(type)) {
                    attachmentHtml = `
                <div class="mt-2 text-left">
                    <a href="/storage/${event.message.attachment_path}" target="_blank">
                        <img src="/storage/${event.message.attachment_path}" class="rounded-lg max-w-full h-auto max-h-48 shadow-sm">
                    </a>
                </div>`;
                } else {
                    attachmentHtml = `
                <div class="mt-2 text-left">
                    <a href="/storage/${event.message.attachment_path}" target="_blank" class="flex items-center gap-2 p-2 rounded bg-opacity-10 bg-blue-600 hover:bg-opacity-20 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-xs font-medium truncate">Document (${event.message.attachment_type.toUpperCase()})</span>
                    </a>
                </div>`;
                }
            }

            div.innerHTML = `<div class="bg-slate-100 text-slate-900 max-w-[70%] rounded-2xl px-4 py-2">
                        ${event.message.text ? `<p class="text-sm">${event.message.text}</p>` : ""}
                        ${attachmentHtml}
                        <p class="mt-1 text-[11px] text-slate-500">
                           ${event.message.sender.name} · Just now
                        </p>
                    </div>`;
            conv.append(div);
            conv.scrollTop = conv.scrollHeight;
        },
    );

    conv.scrollTop = conv.scrollHeight;

    const form = document.getElementById("message-form");
    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const input = document.getElementById("message-input");
            const fileInput = document.getElementById("attachment-input");
            const preview = document.getElementById("attachment-preview");
            const btn = document.getElementById("send-message-btn");

            // Disable button and clear inputs early for better UX
            btn.disabled = true;
            const text = input.value;
            input.value = "";
            fileInput.value = "";
            if (preview) preview.classList.add("hidden");

            window.axios
                .post(this.action, formData)
                .then((response) => {
                    btn.disabled = false;
                    const message = response.data.message;

                    // Render message for the sender
                    const div = document.createElement("div");
                    div.classList = "justify-end flex ";

                    let attachmentHtml = "";
                    if (message.attachment_path) {
                        const type = message.attachment_type.toLowerCase();
                        if (["jpg", "jpeg", "png", "gif"].includes(type)) {
                            attachmentHtml = `
                                <div class="mt-2 text-right">
                                    <a href="/storage/${message.attachment_path}" target="_blank">
                                        <img src="/storage/${message.attachment_path}" class="rounded-lg max-w-full h-auto max-h-48 shadow-sm ml-auto">
                                    </a>
                                </div>`;
                        } else {
                            attachmentHtml = `
                                <div class="mt-2 text-right">
                                    <a href="/storage/${message.attachment_path}" target="_blank" class="inline-flex items-center gap-2 p-2 rounded bg-opacity-20 bg-white hover:bg-opacity-30 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-xs font-medium truncate">Document (${message.attachment_type.toUpperCase()})</span>
                                    </a>
                                </div>`;
                        }
                    }

                    div.innerHTML = `<div class="bg-blue-600 text-white max-w-[70%] rounded-2xl px-4 py-2">
                                        ${message.text ? `<p class="text-sm">${message.text}</p>` : ""}
                                        ${attachmentHtml}
                                        <p class="mt-1 text-[11px] text-blue-100">
                                           Moi · Just now
                                        </p>
                                    </div>`;
                    conv.append(div);
                    conv.scrollTop = conv.scrollHeight;
                })
                .catch((error) => {
                    btn.disabled = false;
                    input.value = text; // Restore text on error
                    console.error(error);
                    alert("Erreur lors de l'envoi du message.");
                });
        });
    }
}
