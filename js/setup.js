document.addEventListener('DOMContentLoaded', function() {
    loadPokemonList();

    const addPokemonButton = document.getElementById('addPokemon');
    addPokemonButton.addEventListener('click', function() {
        openAddForm();
    });
});

function openAddForm() {
    const pokeInfoElement = document.getElementById('poke-info');
    pokeInfoElement.innerHTML = `
        <h2>Agregar Pokémon</h2>
        <form id="addPokemonForm">
            <label>Nombre: <input type="text" name="name" required></label><br>
            <label>Tipo: <input type="text" name="type" required></label><br>
            <label>Tipo Secundario: <input type="text" name="type2"></label><br>
            <label>Altura: <input type="number" name="height" required></label><br>
            <label>Peso: <input type="number" name="weight" required></label><br>
            <label>HP: <input type="number" name="hp" required></label><br>
            <label>Ataque: <input type="number" name="attack" required></label><br>
            <label>Defensa: <input type="number" name="defense" required></label><br>
            <label>Ataque Especial: <input type="number" name="spattack" required></label><br>
            <label>Defensa Especial: <input type="number" name="spdefense" required></label><br>
            <label>Velocidad: <input type="number" name="speed" required></label><br>
            <label>URL de la Imagen: <input type="text" name="image" required></label><br>
            <button type="submit">Agregar</button>
        </form>
    `;

    document.getElementById('addPokemonForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        fetch('add_pokemon.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadPokemonList();
                alert('Pokémon agregado exitosamente');
            } else {
                alert('Error al agregar Pokémon: ' + data.message);
            }
        });
    });
}
