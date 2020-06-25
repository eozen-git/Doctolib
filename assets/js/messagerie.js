let results = document.getElementById('messageArea');

window.onload = function getMessages() {
    fetch('/api/conversation')
        .then(response => response.json())
        .then(conversation => {

            for (message of conversation) {
                let div = document.createElement('div');
                div.className = 'doctor';
                let p = document.createElement('p');
                p.innerText = message.message;
                div.appendChild(p);
                let p2 = document.createElement('p');
                p2.innerText = message.postAt;
                div.appendChild(p2);
                results.appendChild(div);

                results.scrollIntoView({
                    behavior: "smooth",
                    block: "end",
                    inline: "nearest"
                })
            }

        })
}

document.addEventListener('keyup', function (e) {

    if (e.key === 'Enter') {
        let input = document.getElementsByName('message[message]');
        input.value = "";
    }

})


// document.getElementById('btn-message').addEventListener('click', function (e) {
//
//     if (document.getElementById('message_message').value.length > 3) {
//         let message_message = document.getElementById('message_message');
//         let message = message_message.value;
//
//         let messageArea = document.getElementById('messageArea');
//
//         let div = document.createElement('div');
//         let p = document.createElement('p');
//         p.innerHTML = message;
//         div.className = 'doctor';
//
//         div.appendChild(p);
//         message_message.value = "";
//         messageArea.appendChild(div);
//         messageArea.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"})
//     }
// });
