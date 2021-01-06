# Lenguaje de Consulta para la base de datos de Northwind
 Lenguaje de consulta para una appWeb que usa la base de datos Northwind. La aplicación consta de un formulario con una caja de texto y un botón de envío.

La aplicación Web está hecha en PHP-MySQL y consta de un formulario con una caja de texto y un botón de envío. El usuario proporcionará una cadena de consulta que
incorpora operadores y funciones. 
La página presenta los resultados de la consulta en la base de datos. La consulta se realizará sobre los siguientes tres campos por omisión:

products.name  
products.quantity_per_unit  
products.category  
Operadores: AND, OR, NOT  
Funciones: CADENA, PATRON, CAMPOS  

#### Gramática del lenguaje:  
Consulta → Expresión | Expresión CAMPOS()  
Expresión → Expresión Operador Expresión | Términos  
Operador → AND | OR  
Términos →  Términos Término | Término  | NOT Término  
Término →  PalabraClave | CADENA() | PATRON()  

#### Ejemplos de cadenas de consulta:  

**Potato Chips :** Potato OR Chips : todos los registros que tengan las palabras potato o chips (no sensible a mayúsculas) en los campos por omisión  
**Potato AND Chips :** todos los registros que tengan potato y chips (no sensible a mayúsculas)  en los campos por omisión  
**Potato AND NOT Chips :** todos los registros que tengan potato y no tengan chips (no sensible a mayúsculas)  en los campos por omisión  
**CADENA(Potato Chips) :** todos los registros que tengan la frase exacta "potato chips" (no sensible a mayúsculas)  en los campos por omisión  
**PATRON(Pot) :** todos los registros que tengan como prefijo, infijo o sufijo la palabra pot (no sensible a mayúsculas) en alguna de las palabras 
de los campos por omisión  
**CAMPOS(suppliers.company) :** la consulta se limitará al campo suppliers.company  
**CAMPOS(suppliers.company, suppliers.job_title) :** la consulta se limitará a los campos suppliers.company y suppliers.job_title. 
Se pueden indicar n campos pero tienen que ser todos de una misma tabla. Esta función no requiere ningún operador e irá al final de la cadena de consulta  
**Papas Potato AND NOT Chips AND CADENA (con chile) OR PATRON (sabri) CAMPOS (products.description)**

#### Imágenes:
![img1](https://github.com/UsagiHaku/Lenguaje-de-Consulta-para-db-Northwind/blob/main/Captura%20de%20Pantalla%202021-01-04%20a%20la(s)%2011.24.07.png "Imagen 1")  
![img2](https://github.com/UsagiHaku/Lenguaje-de-Consulta-para-db-Northwind/blob/main/Captura%20de%20Pantalla%202021-01-04%20a%20la(s)%2011.24.01.png "Imagen 2")

## Instalación 🔧

#### Instalación de PHP en Mac usando la terminal (PHP 7.3)

```
curl -s https://php-osx.liip.ch/install.sh | bash -s 7.3
```
#### Instalación de PHP en Linux usando la terminal (PHP 5)

```
apt-get install php5-common libapache2-mod-php5 php5-cli
```

#### Más información sobre el proceso de instalación
https://www.geeksforgeeks.org/how-to-execute-php-code-using-command-line/  
https://www.php.net/manual/es/install.php


## Ejecución 🔧

Para correr el proyecto, usamos el siguiente comando:

```
php file_name.php

```
Podemos iniciar el servidor para probar el código php usando el siguiente comando:

```
php -S localhost:8080 
```

## Herrramientas 🛠️

https://github.com/dalers/mywind  
https://www.mysqltutorial.org/basic-mysql-tutorial.aspx  
https://www.php.net/  


