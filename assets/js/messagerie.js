
let field = document.getElementById('animal_search_animalSearch');
let results = document.getElementById('animal_results');

field.addEventListener('input', function (e) {
    e.preventDefault();
    let animalSearch = field.value;
    if(animalSearch.length>=3) {
        fetch('/animal/search/' + animalSearch)
            .then(response => response.json())
            .then(animals => {
                results.innerText = '';
                let ul = document.createElement('ul');
                for (animal of animals) {
                    let link = document.createElement('a');
                    link.href = '/animal/details/' + animal.id;
                    link.innerText = animal.name;

                    let li = document.createElement('li');
                    li.appendChild(link);
                    ul.appendChild(li);
                }

                results.appendChild(ul);
            });
    }
});
