let results = document.getElementById('messageArea');
let message_message = document.getElementById('message_message');
let click = document.getElementById('click')
let reset = document.getElementById('return')
// addEventListener
reset.addEventListener('click', function (e) {
    message_message.value = 'home'
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
                if (message.message === "home") {
                    let divLink = welcome()
                    results.appendChild(divLink)
                }else if (message.message.match("^The available")) {
                    let divLink = drugs(message.message)
                    results.appendChild(divLink)
                }else if (message.message.match("^The medicines")) {
                    let divLink = medocs(message.message)
                    results.appendChild(divLink)
                }else if (message.message.match("^The diseases you")) {
                    let divLink = drugs(message.message)
                    results.appendChild(divLink)
                }else if (message.message.match("^The active")) {
                    let divLink = detail(message.message)
                    results.appendChild(divLink)
                } else {
                    let div = createBubble(message.message)
                    results.appendChild(div);
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

function detail(medics) {
    let ul = document.createElement('ul')
    let div = document.createElement('div')
    let array = medics.split('-')
    div.className = 'doctor'

    for (let i = 0; i < array.length; i++) {

        let detail = array[i].split(':')
        let li = document.createElement('li')
        let b = document.createElement('b')
        if (detail[1] !== undefined) {
            b.innerText = ': ' + detail[1]
        }
        li.innerText = detail[0]
        li.appendChild(b)
        ul.appendChild(li)
    }
    div.appendChild(ul)
    return div
}

function drugs(drugs) {
    let ul = document.createElement('ul')
    let div = document.createElement('div')
    let array = drugs.split(':')
    let h = document.createElement('h4')

    div.className = 'doctor'
    array.pop()
    h.innerText = array[0]
    ul.appendChild(h)
    for (let i = 1; i < array.length; i++) {
        let li = document.createElement('li')
        let link = createBtn(array[i], '/drugs/meds/' + array[i])
        link.className = 'link-li'
        li.appendChild(link)
        ul.appendChild(li)
    }
    div.appendChild(ul)
    return div
}

function medocs(drugs) {
    let ul = document.createElement('ul')
    let div = document.createElement('div')
    let array = drugs.split(':')
    let h = document.createElement('h4')

    div.className = 'doctor'
    array.pop()
    h.innerText = array[0]
    ul.appendChild(h)
    for (let i = 1; i < array.length; i++) {
        let li = document.createElement('li')
        let link = createBtn(array[i], '/drugs/generics/' + array[i])
        link.className = 'link-li'
        li.appendChild(link)
        ul.appendChild(li)
    }
    div.appendChild(ul)
    return div
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
    let btn1 = createBtn('Diseases', '/disease/index');
    let btn2 = createBtn('Drugs', '/drugs/index');
    let divLink = document.createElement('div');
    let divInfo = document.createElement('div');
    let p = document.createElement('p');
    let pInfo = document.createElement('p');
    let div = document.createElement('div');
    divInfo.className = 'covid'
    divLink.className = "link my-2"
    div.className = "doctor"

    pInfo.innerText = 'ALERT COVID-19: Make sure you disinfect your hands and your practice between patients'
    p.innerText =
        "Welcome doctor, what would you like ?"
    divLink.appendChild(btn1)
    divLink.appendChild(btn2)
    div.appendChild(p)
    divInfo.appendChild(pInfo)
    results.appendChild(divInfo)
    results.appendChild(div)
    return results.appendChild(divLink)
}
