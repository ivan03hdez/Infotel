Para que se carguen diferentes clases necesitamos poner estas lineas en el archivo php.ini
situado en PATH_XAMP_INSTALLATION\php\php.ini:

extension=C:\xampp\php\ext\php_mysqli.dll
extension=mbstring
extension=openssl

La pagina de login permite loguearse tanto a clientes como a empleados, pero la pagina de registro solo permite el registro de clientes normales. Esto es así ya que hemos considerado que para crear empleados, y sobretodo administradores, la propia cadena hotelera les proporcionaria ya unas credenciales para iniciar sesión en el Servidor web.