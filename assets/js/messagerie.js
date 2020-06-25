let results = document.getElementById('messageArea');

window.onload = function getMessages() {
    fetch('/api/conversation')
        .then(response => response.json())
        .then(conversation => {

            for (message of conversation) {
                let div = document.createElement('div');
                let p = document.createElement('p');
                let p2 = document.createElement('p');

                div.className = 'doctor';
                p.innerText = message.message;

                p2.innerText = message.postAt;

                div.appendChild(p);
                div.appendChild(p2);

                results.appendChild(div);

                if (message.message === 'Bonjour Docteur, que voulez vous ?') {

                    let choice1 = document.createElement('a');
                    let choice2 = document.createElement('a');
                    let divLink = document.createElement('div');

                    divLink.className = "link my-2"
                    choice1.className = "btn btn-sm"
                    choice2.className = "btn btn-sm"

                    choice1.innerText = "Traitements"
                    choice2.innerText = "Maladies"

                    choice1.setAttribute("href", "/drugs/index")
                    choice2.setAttribute("href", "/diseases/index")

                    divLink.appendChild(choice1);
                    divLink.appendChild(choice2);

                    results.appendChild(divLink)
                }

                results.scrollIntoView({
                    behavior: "smooth",
                    block: "end",
                    inline: "nearest"
                })
            }

        })
}


// document.addEventListener('keyup', function (e) {
//     if (e.key === 'Enter') {
//         let input = document.getElementsByName('message[message]');
//         input.value = "";
//     }
// })


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
