function loadPokemonInfo(no) {
    fetch(`get_pokemon_info.php?no=${no}`)
        .then(response => response.json())
        .then(data => {
            const pokeInfoElement = document.getElementById('poke-info');
            pokeInfoElement.innerHTML = `
                <h2>${data.name}</h2>
                <img src="${data.image}" alt="${data.name}">
                <p>Tipo: ${data.type} ${data.type2 ? '/' + data.type2 : ''}</p>
                <p>Altura: ${data.height} cm</p>
                <p>Peso: ${data.weight} kg</p>
                <p>HP: ${data.hp}</p>
                <p>Ataque: ${data.attack}</p>
                <p>Defensa: ${data.defense}</p>
                <p>Ataque Especial: ${data.spattack}</p>
                <p>Defensa Especial: ${data.spdefense}</p>
                <p>Velocidad: ${data.speed}</p>
                <button id="editPokemon">Editar</button>
                <button id="deletePokemon">Eliminar</button>
            `;

            document.getElementById('editPokemon').addEventListener('click', () => {
                openEditForm(data);
            });

            document.getElementById('deletePokemon').addEventListener('click', () => {
                deletePokemon(data.no);
            });
        });
}

function deletePokemon(no) {
    if (confirm('¿Estás seguro de que quieres eliminar este Pokémon?')) {
        fetch('delete_pokemon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `no=${no}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadPokemonList();
                document.getElementById('poke-info').innerHTML = '';
                alert('Pokémon eliminado exitosamente');
            } else {
                alert('Error al eliminar Pokémon: ' + data.message);
            }
        });
    }
}

function openEditForm(data) {
    const pokeInfoElement = document.getElementById('poke-info');
    pokeInfoElement.innerHTML = `
        <h2>Editar Pokémon</h2>
        <form id="editForm">
            <input type="hidden" name="no" value="${data.no}">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="${data.name}" required>
            
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" value="${data.type}" required>
            
            <label for="type2">Tipo Secundario:</label>
            <input type="text" id="type2" name="type2" value="${data.type2}">
            
            <label for="height">Altura (cm):</label>
            <input type="number" id="height" name="height" value="${data.height}" required>
            
            <label for="weight">Peso (kg):</label>
            <input type="number" id="weight" name="weight" value="${data.weight}" required>
            
            <label for="hp">HP:</label>
            <input type="number" id="hp" name="hp" value="${data.hp}" required>
            
            <label for="attack">Ataque:</label>
            <input type="number" id="attack" name="attack" value="${data.attack}" required>
            
            <label for="defense">Defensa:</label>
            <input type="number" id="defense" name="defense" value="${data.defense}" required>
            
            <label for="spattack">Ataque Especial:</label>
            <input type="number" id="spattack" name="spattack" value="${data.spattack}" required>
            
            <label for="spdefense">Defensa Especial:</label>
            <input type="number" id="spdefense" name="spdefense" value="${data.spdefense}" required>
            
            <label for="speed">Velocidad:</label>
            <input type="number" id="speed" name="speed" value="${data.speed}" required>
            
            <button type="submit">Guardar Cambios</button>
        </form>
    `;

    document.getElementById('editForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('edit_pokemon.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  loadPokemonList();
                  alert('Pokémon editado exitosamente');
              } else {
                  alert('Error al editar Pokémon: ' + data.message);
              }
          });
    });
}
