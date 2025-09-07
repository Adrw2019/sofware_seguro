# Inventario Tecnológico

Este proyecto es una aplicación web para la gestión de inventarios tecnológicos. Permite a los usuarios registrarse, iniciar sesión y recuperar contraseñas, así como gestionar un inventario de artículos tecnológicos.

## Características

- **Registro de Usuarios**: Los nuevos usuarios pueden registrarse en la aplicación.
- **Inicio de Sesión**: Los usuarios pueden iniciar sesión con sus credenciales.
- **Recuperación de Contraseña**: Los usuarios pueden recuperar su contraseña en caso de olvidarla.
- **Gestión de Inventario**: Los usuarios pueden añadir, actualizar, eliminar y visualizar artículos en el inventario.

## Estructura del Proyecto

```
inventario-tecnologico
├── src
│   ├── controllers          # Controladores para la lógica de negocio
│   ├── models               # Modelos de datos
│   ├── routes               # Rutas de la aplicación
│   ├── views                # Vistas para la interfaz de usuario
│   └── app.js               # Punto de entrada de la aplicación
├── public                   # Archivos estáticos (CSS, JS)
├── config                   # Configuración de la base de datos
├── package.json             # Dependencias y scripts del proyecto
├── .env                     # Variables de entorno
└── README.md                # Documentación del proyecto
```

## Instalación

1. Clona el repositorio:
   ```
   git clone <URL_DEL_REPOSITORIO>
   ```
2. Navega al directorio del proyecto:
   ```
   cd inventario-tecnologico
   ```
3. Instala las dependencias:
   ```
   npm install
   ```
4. Configura la base de datos en el archivo `.env` con los detalles de tu servidor WAMP.

## Uso

1. Inicia el servidor:
   ```
   npm start
   ```
2. Abre tu navegador y visita `http://localhost:3000` para acceder a la aplicación.

## Contribuciones

Las contribuciones son bienvenidas. Si deseas contribuir, por favor abre un issue o envía un pull request.

## Licencia

Este proyecto está bajo la Licencia MIT.