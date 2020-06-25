let results = document.getElementById('messageArea')

window.onload = function getMessages() {
    fetch('/api/conversation')
        .then(response => response.json())
        .then(conversation => {

                for(message of conversation) {
                let div = document.createElement('div');
                let p = document.createElement('p');
                p.innerText = message.message;
                div.appendChild(p);
                let p2 = document.createElement('p');
                div.appendChild(p2);
                results.appendChild(div);
            }

        })
    const messageArea = document.querySelector('#chatArea');
    messageArea.scrollTop = messageArea.scrollHeight;
}
document.addEventListener('keyup', function (e) {

    if (e.key === 'Enter') {
        let input = document.getElementsByName('message[message]');
        input.value = "";
    }

})
