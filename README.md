El sistema detecta los niveles de temperatura, humedad del aire, humedad de la
tierra, e iluminación de un cultivo. Estos niveles son medidos cada 15 segundos y
enviados a un servidor (puede ser local o remoto).
El sistema posee los siguientes sensores:
 Humedad del aire y temperatura (puede ser DHT 11 o DHT 22).
 Humedad de la tierra (cualquier ref., que mida un valor en un rango
especificado).
 Iluminación (cualquier ref., que mida un valor en un rango especificado).
El sistema tiene los siguientes actuadores:
 Un led ROJO que indica que superó la temperatura máxima.
 Un led AZUL que indica que está por debajo de la temperatura mínima.
 Un motor del riego que se activa o desactiva manual o automáticamente.
El motor del riego, puede estar en modo manual, o automático. Si está en modo
manual, se podrá activar y desactivar el riego de forma remota. Si está en modo
automático, éste riego se activará solamente cuando la medida de humedad de la
tierra sea inferior al valor mínimo.
Los datos límite de este requerimiento son:
 Máximo de temperatura
 Mínimo de temperatura
 Mínimo de humedad de la tierra
Los tipos de evento de este requerimiento son:
• Se superó la temperatura máxima
• Está por debajo de la temperatura mínima.
• Humedad de la tierra está por debajo del mínimo.
• Motor se activó en modo manual.
• Motor se desactivó en modo manual.
• Motor se activó en modo automático.
• Motor se desactivó en modo automático.

Además de las tablas que ya tienen creadas (datos_medidos, datos_limite, eventos,
registro_eventos) para el requerimiento de colocar el riego en modo manual o
automático, necesitarían una tabla adicional. También necesitan desarrollar una
nueva interfaz que permita ver el modo actual del riego, y se pueda cambiar a modo
remoto o automático. También otra interfaz donde permita (si está en modo manual)
activar o desactivar el riego.
Se deben almacenar en una tabla de la base de datos (que sería la actual tabla de
datos_medidos), cada 15 segundos, los datos recolectados de todos los sensores
que se mencionaron que tiene el sistema. La tabla que almacene los datos debe
recibir desde el dispositivo HW los siguientes campos: fecha, hora, temperatura,
humedad aire, humedad tierra, iluminación. La tabla datos_medidos estaría
inicialmente vacía y a medida que el dispositivo vaya haciendo medidas, se
debe ir llenando.
También deben tener una tabla que indique los datos máximo y mínimo de
temperatura y dato mínimo de humedad de la tierra (esa tabla sería la actual
datos_limite).
Recuerden que esta tabla tiene solamente 3 filas, que son datos fijos, no se debe
actualizar, ni insertar más datos, ya que la tabla solo servirá para consultarla.
El evento que ocurra se debe registrar en la base de datos, con la fecha y hora
respectivas. Recuerden que para esto se requiere de dos tablas, la tabla evento que tiene un número
de filas fijo (7 filas solamente) con los eventos descritos en el párrafo anterior; y
además la tabla registro_eventos. La tabla registro eventos debe iniciar vacía, y
cada vez que vaya ocurriendo un evento, deben irse registrando nuevos datos
(nuevas filas).
Deben tener en cuenta que el programa php que vaya recibiendo los datos
para insertar en la tabla datos_medidos, además de insertar datos en dicha
tabla, debe verificar si debe registrar también algún evento en la tabla
registro_eventos. Si es así, debe realizarse también dicha inserción en esa otra
tabla.
Finalmente, deben tener en cuenta que deben crear una nueva interfaz para
consultar los eventos que se vayan registrando, con la opción de poder filtrar los
datos con una fecha inicial y una fecha final.
