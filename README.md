# supersaiyanross
Proyecto de gestión de incidencias para la asignatura Implantación de Aplicaciones Web (2º ASIR). Ahora dockerizada 😎

### Lo que funciona:
- Abrir incidencias
- Registro e inicio de sesión
- Búsqueda de incidencias
- Editar o borrar incidencias
- Estadísticas.

### Cosas que no:
- El botón de copia de seguridad no hace nada cuando la aplicación web está contenida.

## Instalación

El repositorio contiene un archivo compose para crear los contenedores necesarios para ejecutar la app. Para ejecutar la web app sigue los siguientes pasos:

1. Instala Docker Engine y Docker Compose. https://docs.docker.com/engine/install/
2. Clona el repositorio en una carpeta localizable.
> $ git clone https://github.com/theafi/supersaiyanross.git
3. Navega a la carpeta donde has clonado el repositorio desde una terminal o desde Windows PowerShell y construye los contenedores con Docker Compose:
> docker compose -f 'compose.yaml' up -d --build
4. Accede a la aplicación web desde cualquier navegador entrando en **http://localhost:80**

Al acceder a la aplicación web se crea un usuario de administrador con las siguientes credenciales:

**Usuario**: *admin@rmi.com*
**Contraseña**: *admin*

Es aconsejable cambiar la contraseña de este usuario al primer inicio de sesión, o eliminarlo tras crear un nuevo administrador desde el Panel de control.

La contraseña de root de la base de datos se encuentra en el archivo *default.env*. Es aconsejable cambiar la constraseña dentro del archivo una vez clonado el repositorio, o no utilizar el archivo y utilizar una variable de entorno diferente.
