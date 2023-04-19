# Sistema de Sorteos

Este sistema contiene un login de usuarios, CRUD de sorteos, premios, premios por sorteo y los jugadores son tomados de una API, donde se valida si el jugador existe solo una vez y si pertence a varios sorteos.

## Empezando

Clona el repositorio

```bash
git clone https://github.com/angelbonillago/sistema_sorteos.git
```

## Configuracion de la Base de datos

    En el archivo 'Config/Config.php' se encuentra las credenciales de la Base de datos.  En el proyecto tambien se encuentra el archivo SQL `ruleta.sql` con la base de datos lista para importar.

```bash
    <?php
    const BASE_URL = "http://localhost/ruleta/";
    const HOST = "localhost";
    const USER = "root";
    const PASS = "";
    const DB = "ruleta";
    const CHARSET = "charset=utf8";

?>

```

## Usuario de prueba 
    Para el login, usar las siguientes credenciales

```bash
    usuario: abonillago@gmail.com
    contrasena:  admin

```

## Para actualizar los jugadores

- Los jugadores son consumidas por una API, que contiene la siguiente estructura : 

```
    HTTP 200 OK
    Allow: GET, POST, HEAD, OPTIONS
    Content-Type: application/json
    Vary: Accept

    [
        {
            "id": 1,
            "dni": "75888893",
            "id_sorteo": 8,
            "intentos": 2
        },
        {
            "id": 2,
            "dni": "98765432",
            "id_sorteo": 8,
            "intentos": 5
        },
```

- El codigo fuente para recibir el JSON se encuentra en el archivo `Assets/js/pages/jugador.js`, especificamente en las siguientes lineas.

```
async function buscarJugadores() {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/participante/');
        const jugadores = response.data; // Guardamos los valores de la respuesta en una variable
        .....
        ...
        ..
        .        

    } catch (error) {
        console.error('error -> '+error);
    }
}

```
