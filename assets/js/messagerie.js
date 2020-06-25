let results = document.getElementById('messageArea');
let message_message = document.getElementById('message_message');

let reset = document.getElementById('return')

reset.addEventListener('click', function (e) {
    message_message.value = 'return'
    let click = document.getElementById('click');
    click.click()
})

window.onload = function getMessages() {
    let control = document.getElementById('messageArea');

    if (control.innerText === "") {
        let divLink = welcome()
        results.appendChild(divLink)
    }

    fetch('/api/conversation')
        .then(response => response.json())
        .then(conversation => {

            for (message of conversation) {
<<<<<<< HEAD
                let div = document.createElement('div');
                let p = document.createElement('p');
                let p2 = document.createElement('p');

                div.className = 'doctor';
                p.innerText = message.message;

                p2.innerText = message.postAt;

                div.appendChild(p);

                div.appendChild(p2);
=======
                let div = createBubble(message.message)
>>>>>>> response_bot

                results.appendChild(div);

                if (message.message === "return") {
                    let divLink = welcome()
                    results.appendChild(divLink)
                }

                let message_message = document.getElementById('message_message');
                message_message.value = "";

                results.scrollIntoView({
                    behavior: "smooth",
                    block: "end",
                    inline: "nearest"
                })
            }
        })
}

function createBtn(name, link) {

    let btn = document.createElement('a');
    btn.className = "btn btn-sm"
    btn.innerText = name
    btn.setAttribute("href", link)
    return btn
}

function createBubble(txt) {

    let div = document.createElement('div');
    let p = document.createElement('p');

    div.className = 'doctor';
    p.innerText = txt

    div.appendChild(p);
    return div
}

function welcome() {
    let btn1 = createBtn('Diseases', '/disease/index')
    let btn2 = createBtn('Drugs', '/drugs/index')

    let divLink = document.createElement('div');
    let p = document.createElement('p');
    let div = document.createElement('div');

    divLink.className = "link my-2"
    div.className = "doctor"
    p.innerText =
        "Welcome doctor, what would you like ?"

    divLink.appendChild(btn1)
    divLink.appendChild(btn2)
    div.appendChild(p)
    results.appendChild(div)
    return results.appendChild(divLink)
}


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
