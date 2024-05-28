function loadPokemonList() {
    fetch('get_pokemon_list.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            displayPokemonList(data);
        })
        .catch(error => {
            console.error('Error al obtener la lista de Pokémon:', error);
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
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            const filteredPokemon = data.filter(pokemon => 
                pokemon.name.toLowerCase().includes(query.toLowerCase())
            );
            displayPokemonList(filteredPokemon);
        })
        .catch(error => {
            console.error('Error al buscar Pokémon:', error);
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

