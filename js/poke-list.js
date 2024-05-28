function loadPokemonList() {
    fetch('get_pokemon_list.php')
        .then(response => response.json())
        .then(data => {
            displayPokemonList(data);
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
