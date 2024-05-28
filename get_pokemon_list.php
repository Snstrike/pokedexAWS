function loadPokemonList() {
    fetch('get_pokemon_list.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error from server:', data.error);
                return;
            }
            displayPokemonList(data);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function displayPokemonList(pokemonList) {
    const pokeListElement = document.getElementById('poke-list');
    pokeListElement.innerHTML = '';
    pokemonList.forEach(pokemon => {
        const pokemonItem = document.createElement('div');
        pokemonItem.classList.add('pokemon-item');
        pokemonItem.innerHTML = `
            <img src="${pokemon.image}" alt="${pokemon.name}">
            <span>${pokemon.name}</span>
        `;
        pokemonItem.addEventListener('click', () => {
            loadPokemonInfo(pokemon.id);
        });
        pokeListElement.appendChild(pokemonItem);
    });
}

function searchPokemon(query) {
    fetch('get_pokemon_list.php')
        .then(response => response.json())
        .then(data => {
            const filteredPokemon = data.filter(pokemon => 
                pokemon.name.toLowerCase().includes(query.toLowerCase())
            );
            displayPokemonList(filteredPokemon);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    loadPokemonList();

    const searchInput = document.getElementById('search');
    searchInput.addEventListener('input', function() {
        searchPokemon(searchInput.value);
    });

    const addPokemonButton = document.getElementById('addPokemon');
    addPokemonButton.addEventListener('click', function() {
        openAddForm();
    });
});
