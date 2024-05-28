#!/bin/bash

# Variables de configuración
DB_HOST="<endpoint-RDS>"
DB_NAME="pokedex"
DB_USER="admin"
DB_PASS="password"

# Actualizar paquetes e instalar dependencias
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php mysql-client

# Subir archivos de la aplicación
cd /var/www/html
sudo rm -rf *
sudo git clone https://github.com/tuusuario/pokedex.git .

# Configurar conexión a la base de datos en archivos PHP
for file in add_pokemon.php delete_pokemon.php edit_pokemon.php get_pokemon_info.php get_pokemon_list.php
do
  sudo sed -i "s/localhost/$DB_HOST/g" $file
  sudo sed -i "s/dbname/$DB_NAME/g" $file
  sudo sed -i "s/dbuser/$DB_USER/g" $file
  sudo sed -i "s/dbpass/$DB_PASS/g" $file
done

# Crear la base de datos y poblarla
php databasebuilder.php
php data_inserter.php

# Reiniciar Apache
sudo systemctl restart apache2
