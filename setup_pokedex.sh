#!/bin/bash

# Variables de configuración
DB_HOST="pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com"
DB_NAME="pokedex"
DB_USER="admin"
DB_PASS="password"

# Actualizar paquetes e instalar dependencias
sudo apt-get update
sudo apt-get install -y apache2 php libapache2-mod-php php-mysql mysql-client

# Limpiar el directorio y clonar el repositorio
cd /var/www/html || { echo "Failed to change directory"; exit 1; }
sudo rm -rf ./* .git

echo "Contents of /var/www/html after cleanup:"
ls -la /var/www/html

# Verificar que el directorio esté vacío
if [ "$(ls -A /var/www/html)" ]; then
   echo "Directory is not empty"
   exit 1
fi

# Clonar el repositorio
sudo git clone https://github.com/Snstrike/pokedexAWS . || { echo "Git clone failed"; exit 1; }

echo "Contents of /var/www/html after git clone:"
ls -la /var/www/html

# Configurar conexión a la base de datos en archivos PHP
for file in add_pokemon.php delete_pokemon.php edit_pokemon.php get_pokemon_info.php get_pokemon_list.php
do
  if [ -f "$file" ]; then
    sudo sed -i "s/localhost/$DB_HOST/g" $file
    sudo sed -i "s/dbname/$DB_NAME/g" $file
    sudo sed -i "s/dbuser/$DB_USER/g" $file
    sudo sed -i "s/dbpass/$DB_PASS/g" $file
  else
    echo "$file not found, skipping..."
  fi
done

# Pausar para permitir la propagación de DNS
sleep 60

# Crear la base de datos y poblarla
if [ -f "databasebuilder.php" ]; then
  php databasebuilder.php || { echo "databasebuilder.php execution failed"; exit 1; }
else
  echo "databasebuilder.php not found, skipping..."
fi

if [ -f "data inserter.php" ]; then
  php 'data inserter.php' || { echo "data inserter.php execution failed"; exit 1; }
else
  echo "data inserter.php not found, skipping..."
fi

# Reiniciar Apache
sudo systemctl restart apache2
