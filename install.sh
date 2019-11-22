echo "===PROGRAMME D'INSTALLATION LINUX==="
echo "docker-compose doit etre installe"

if (( $EUID != 0 )); then 
    echo "merci de lancer le programme avec"
    echo "sudo ./install.sh"
    exit
fi

echo "Supprime les fichiers de base de donnees..."
sudo rm -r ./docker/postgres/*

echo "Construit la stack..."
docker-compose build

echo ""
echo "===L'APPLICATION EST PRETE==="
echo "Pour la lancer, effectuez la commande 'docker-compose up'"