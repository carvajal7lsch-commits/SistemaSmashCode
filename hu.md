HU01-Acceso a módulos de inglés médico por nivel de dificultad
Como aprendiz,
quiero acceder a módulos de inglés médico organizados por nivel de dificultad,
para mejorar mi comunicación con pacientes anglófonos en entornos clínicos.
Criterios de Aceptacion:
• Veo la lista de niveles con indicador visual: bloqueado (candado), en progreso (barra) y completado (check).
• Accedo a un RAP y navego sus secciones (vocabulario, ejercicios, diálogos, quiz).
• El progreso se guarda automáticamente; puedo retomar desde donde lo dejé.
• El nivel 1 (A1 – Básico) está disponible desde mi registro.
• El siguiente nivel se desbloquea al completar ≥ 80% del nivel anterior.
HU02-Escuchar pronunciación con IPA y marcar palabras difíciles
Como aprendiz,
quiero escuchar la pronunciación de términos médicos con transcripción fonética IPA y marcar los que se me dificultan,
para mejorar mi comprensión auditiva y pronunciación en contextos clínicos.
Criterios de Aceptacion:
• Veo el término con su transcripción IPA.
• El audio de pronunciación inicia en < 1.5 s.
• Puedo repetirlo sin recargar la página.
• Puedo marcar palabras como "difíciles".
• Tengo una sección de repaso de palabras marcadas.
HU03-Previsualizar y publicar RAPs desde panel centralizado
Como administrador,
quiero previsualizar el contenido completo de cada RAP (vocabulario, ejercicios, diálogos, quiz) antes de publicarlo,
para asegurar calidad pedagógica y alineación con el programa técnico de enfermería.
Criterios de Aceptacion:
• Accedo a cada RAP y veo el estado de sus 5 componentes (vocabulario, pronunciación, ejercicios, diálogos, quiz).
• El contenido aparece marcado como "completo" solo cuando todos los componentes obligatorios están configurados.
• Puedo previsualizar la vista exacta que verá el aprendiz antes de publicar.
• Publico o desactivo un RAP con un solo clic; un RAP inactivo no es visible para aprendices.
• La desactivación es lógica (soft-delete); el contenido se conserva para futuras activaciones.

HU04-Gestión completa de usuarios por el administrador
Como administrador,
quiero gestionar todos los usuarios de la plataforma (crear, editar, suspender y eliminar) con control de roles,
para controlar el acceso y garantizar la integridad de los datos de cada usuario.
Criterios de Aceptacion:
• Puedo buscar usuarios por nombre, correo o rol.
• Al editar datos del usuario, el historial de interacciones se conserva.
• Al suspender un usuario, pierde acceso inmediatamente.
• La eliminación es soft-delete con confirmación obligatoria.
• Veo el log de actividad de cada usuario.
HU05-Panel de progreso personal con heatmap y puntajes históricos
Como aprendiz,
quiero ver mi progreso detallado en niveles, RAPs y quizzes desde mi panel personal,
para saber exactamente qué he completado, mi desempeño y cuánto me falta para finalizar el curso.
Criterios de Aceptacion:
• Veo % de avance por nivel y por RAP.
• Veo mis puntajes de quizzes con histórico de intentos.
• Veo días activos en heatmap (últimos 3 meses mínimo).
• Recibo notificación al desbloquear un nuevo nivel.
• Veo tiempo total invertido y racha de días activos.
HU23-Consultar progreso de aprendices y exportar reportes CSV
Como instructor,
quiero consultar el progreso y los resultados de todos mis aprendices con filtros por nivel, RAP y estado, y exportar los resultados de quizzes a CSV,
para identificar estudiantes con dificultades y brindar acompañamiento pedagógico oportuno.
Criterios de Aceptacion:
• Veo lista de mis aprendices con porcentaje de avance por nivel y por RAP.
• Filtro por nivel, RAP o estado (completado / en progreso / sin iniciar).
• Identifico los ejercicios con mayor tasa de error del grupo.
• Exporto reporte CSV con: ID del aprendiz, nombre, quiz, puntaje, fecha, duración, número de intento y detalle de respuestas.
• No puedo modificar contenido de la plataforma ni gestionar cuentas de otros usuarios.

HU06-Panel de seguimiento pedagógico y exportación de reportes
Como instructor,
quiero consultar el progreso y resultados de todos mis aprendices en un panel de seguimiento pedagógico,
para identificar estudiantes con dificultades y brindar acompañamiento oportuno.
Criterios de Aceptacion:
• Veo lista de aprendices con % de avance por nivel y RAP.
• Puedo filtrar por nivel, RAP o estado (completado / en progreso / sin iniciar).
• Descargo reporte CSV con resultados de quizzes.
• Identifico los ejercicios con más errores del grupo.
• No puedo modificar contenido de la plataforma.


HU07-Retroalimentación inmediata e insignias por logros
Como aprendiz,
quiero recibir retroalimentación inmediata al finalizar cada ejercicio y cada RAP, y ganar insignias por mis logros,
para entender mis errores, reforzar vocabulario débil y mantener la motivación para continuar.
Criterios de Aceptacion:
• Al responder veo si es correcto en < 0.5 s.
• En respuestas incorrectas veo la respuesta correcta con explicación breve.
• Al final del RAP veo resumen: puntaje, áreas de fortaleza y mejora, recomendación de actividades.
• Recibo insignia si apruebo un quiz con 90%+.
• Veo mi posición en la tabla semanal del programa.
HU16-Registro público de aprendices
Como aprendiz,
quiero registrarme en la plataforma ingresando mi nombre completo, correo institucional, número de ficha SENA, programa de formación y contraseña,
para que mi cuenta se active automáticamente y acceda al nivel 1 (A1 – Básico) sin necesidad de intervención del administrador.
Criterios de Aceptacion:
• Completo el formulario con todos los campos obligatorios: nombre, correo, ficha SENA, programa y contraseña (mínimo 8 caracteres, 1 mayúscula, 1 número).
• El sistema rechaza correos duplicados y muestra mensajes de error claros.
• Al registrarme correctamente, recibo un correo de confirmación y mi cuenta se activa.
• El rol "aprendiz" se asigna automáticamente y no puedo modificarlo desde mi perfil.
• El nivel 1 se desbloquea automáticamente tras el primer inicio de sesión.

HU08-Login seguro y recuperación de contraseña
Como usuario del sistema (aprendiz, instructor o administrador),
quiero iniciar sesión con mi correo y contraseña, y recuperar mi contraseña si la olvido,
para acceder a la plataforma de forma segura y no perder el acceso a mi progreso.
Criterios de aceptacion:
• El login con credenciales correctas responde en < 2 s y genera token JWT.
• Tras 5 intentos fallidos la cuenta se bloquea y el usuario recibe notificación.
• El enlace de recuperación de contraseña se envía al correo y expira en 24 h.
• La sesión expira automáticamente tras 30 min de inactividad.
• HTTPS obligatorio; contraseñas almacenadas con bcrypt (factor ≥ 12).
HU09-Crear cuentas de instructor con credenciales temporales
Como administrador,
quiero crear cuentas para instructores desde el panel de administración,
para incorporar nuevos instructores al programa sin que ellos tengan que auto-registrarse.
Criterios de aceptacion:
• Creo una cuenta ingresando nombre, correo y programa asignado.
• El sistema genera credenciales temporales y las envía al correo del instructor.
• El instructor aparece en la lista con rol "Instructor".
• El instructor debe cambiar su contraseña en el primer inicio de sesión.


HU17-Gestionar programas de formación
Como administrador,
quiero crear, editar y desactivar programas de formación (nombre, descripción),
para asignarlos a instructores y aprendices y mantener la oferta curricular actualizada.
Criterios de Aceptacion:
• Veo lista de programas con nombre y descripción.
• Puedo agregar un nuevo programa, editar su nombre/descripción y desactivarlo (soft-delete).
• Al crear un instructor o un aprendiz, puedo asignarle un programa de la lista activa.
• Un programa desactivado no permite nuevas asignaciones pero conserva los usuarios ya vinculados.
• Los cambios se reflejan de inmediato en los perfiles de usuario.

HU10-Editar atributos de los 6 niveles precargados
Como administrador,
quiero editar los atributos de los 6 niveles precargados (nombre, descripción, imagen, estado activo/inactivo),
para mantener la información de los niveles actualizada sin necesidad de intervención técnica.
Criterios de Aceptacion:
• Veo los 6 niveles listados en el panel de administración.
• Puedo editar nombre, descripción e imagen de portada de cada nivel.
• Puedo activar o desactivar un nivel; uno inactivo no es visible para aprendices.
• No puedo crear ni eliminar niveles.
• Los cambios se reflejan de inmediato en la vista del aprendiz.
HU18-Gestionar catálogos de áreas clínicas y categorías gramaticales
Como administrador,
quiero crear, editar y desactivar áreas clínicas y categorías gramaticales del vocabulario médico,
para mantener los filtros del glosario y del contenido de RAPs actualizados y alineados al programa técnico.
Criterios de Aceptacion:
• Veo listados de áreas clínicas (ej. cardiología, urgencias, farmacología) y categorías gramaticales (sustantivo, verbo, adjetivo, etc.).
• Puedo agregar, editar nombre y desactivar (soft-delete) cualquier entrada de catálogo.
• Las entradas desactivadas no aparecen como opciones al crear vocabulario.
• Los cambios se reflejan de inmediato en los filtros del glosario y en las etiquetas de vocabulario.
• No puedo eliminar físicamente una categoría o área que esté en uso por vocabulario existente.

HU19-Crear y editar vocabulario médico dentro de cada RAP
Como administrador,
quiero registrar, editar y desactivar palabras de vocabulario médico dentro de cada RAP con todos sus atributos obligatorios,
para mantener el contenido de aprendizaje actualizado y completo.
Criterios de Aceptacion:
• Registro término en inglés, traducción al español, categoría gramatical, área clínica, nivel de dificultad, transcripción IPA, audio MP3/OGG, imagen representativa, oración de ejemplo clínico y traducción del ejemplo.
• Ningún campo obligatorio aparece vacío al publicar la entrada.
• Puedo editar cualquier campo y desactivar (soft-delete) una entrada de vocabulario.
• Puedo filtrar y buscar vocabulario dentro del panel de administración por RAP, área clínica o categoría.
• Cada cambio se refleja de inmediato en la vista del aprendiz y en el glosario.

HU11-Consultar glosario médico con filtros avanzados
Como aprendiz,
quiero consultar el glosario médico completo de la plataforma con filtros por área clínica, nivel y categoría gramatical,
para encontrar rápidamente cualquier término técnico en inglés aunque no esté en el RAP que estoy cursando actualmente.
Criterios de Aceptacion:
• Accedo al glosario desde el menú principal sin necesidad de estar en un RAP.
• Puedo filtrar por área clínica (ej. cardiología, farmacología), nivel y categoría gramatical.
• Cada entrada muestra: término en inglés, traducción, IPA, ejemplo clínico y audio.
• Puedo reproducir el audio de pronunciación directamente desde el glosario.
• La búsqueda por texto libre encuentra términos en < 1 s.
HU20-Crear ejercicios interactivos dentro de cada RAP
Como administrador,
quiero crear ejercicios interactivos de los 6 tipos dentro de cada RAP (enunciado, instrucciones, opciones, retroalimentación, intentos y puntaje),
para evaluar el aprendizaje del aprendiz de forma variada.
Criterios de Aceptacion:
• Creo ejercicios de: selección múltiple, completar frases, arrastrar y soltar, ordenar diálogo, escucha y escribe, role-play guiado.
• Cada ejercicio tiene enunciado, instrucciones, máximo de intentos, puntaje asignado y retroalimentación por respuesta.
• Las opciones de respuesta se configuran con texto, indicador de correcta y retroalimentación individual.
• Puedo previsualizar el ejercicio antes de publicarlo.
• La eliminación es lógica (soft-delete); el ejercicio desaparece para el aprendiz pero se conserva en base de datos.

HU21-Crear diálogos clínicos sincronizados con audio
Como administrador,
quiero crear diálogos clínicos entre enfermero/a y paciente con turnos ordenados, contexto situacional, participantes y audio sincronizado,
para contextualizar el vocabulario en escenarios reales de atención clínica.
Criterios de Aceptacion:
• Defino título del escenario, contexto situacional, participantes y anotaciones pedagógicas.
• Agrego turnos ordenados con hablante (enfermero/a o paciente), texto en inglés, traducción y audio individual por turno.
• El audio utiliza voces diferenciadas para cada participante.
• Al reproducir, el texto resalta la línea activa sincronizada con su audio.
• El aprendiz puede reproducir por turno individual o el diálogo completo, con pausa, retroceso y repetición sin recargar.
• La eliminación del diálogo o de un turno es lógica (soft-delete).

HU12-Realizar los 6 tipos de ejercicios interactivos
Como aprendiz,
quiero realizar los 6 tipos de ejercicios interactivos disponibles en cada RAP,
para practicar el inglés médico de forma variada y adaptada a situaciones clínicas reales.
Criterios de Aceptacion:
• Selección múltiple con validación inmediata (< 0.5 s).
• Completar frases con banco de palabras visible.
• Arrastrar y soltar términos para relacionar columnas.
• Ordenar los turnos de un diálogo clínico en la secuencia correcta.
• Escuchar un audio y escribir el término médico dictado.
• Simulación de conversación clínica (role-play guiado con opciones de respuesta).
• En cada ejercicio se muestra si la respuesta es correcta/incorrecta en < 0.5 s.
HU13-Reproducir diálogos clínicos con audio sincronizado al texto
Como aprendiz,
quiero reproducir diálogos clínicos entre enfermero/a y paciente con audio sincronizado al texto,
para entrenar mi comprensión auditiva en escenarios reales y practicar el ritmo natural del inglés clínico.
Criterios de Aceptacion:
• Veo el texto del diálogo con la línea activa resaltada mientras suena el audio.
• Escucho voces diferenciadas para enfermero/a y paciente.
• Puedo reproducir el audio por turno individual o el diálogo completo.
• Puedo pausar, retroceder y repetir cualquier turno sin recargar la página.
• El audio de cada turno inicia en < 1.5 s.
HU22-Configurar quizzes de evaluación por RAP
Como administrador,
quiero configurar quizzes al final de cada RAP definiendo número de preguntas, tiempo límite, puntaje mínimo aprobatorio, aleatorización y reintentos permitidos,
para evaluar el dominio del contenido por parte del aprendiz.
Criterios de Aceptacion:
• Defino número de preguntas, tiempo límite, puntaje mínimo (por defecto 60%), aleatorizar preguntas y máximo de reintentos.
• Las preguntas incluyen texto, opciones JSON, respuesta correcta y retroalimentación por pregunta.
• El quiz se publica solo cuando todas las preguntas están configuradas y el admin lo revisa en previsualización.
• Al finalizar el quiz el aprendiz ve: puntaje, porcentaje de aciertos, preguntas incorrectas con respuesta correcta resaltada y estado aprobado/reprobado.
• La eliminación de un quiz o pregunta es lógica (soft-delete).

HU14-Repetir RAPs completados conservando el mejor puntaje
Como aprendiz,
quiero repetir cualquier RAP que ya haya completado todas las veces que quiera,
para reforzar el vocabulario y mejorar mi puntaje hasta dominar completamente el contenido.
Criterios de Aceptacion:
• Veo un botón "Repetir RAP" en cualquier RAP completado.
• Al repetir, el progreso del intento anterior se reinicia para esa sesión.
• El mejor puntaje histórico en el quiz se conserva; no se sobreescribe si obtengo uno menor.
• Cada intento queda registrado como una sesión independiente.
• El nivel de avance general no disminuye al reiniciar un RAP.
HU15-Nivel de perfil, leaderboard semanal y heatmap de actividad
Como aprendiz,
quiero ver mi nivel de perfil actualizado (Novato → Experto Clínico), mi posición en el leaderboard semanal y mi heatmap de actividad,
para mantener la motivación, competir sanamente con mis compañeros y visualizar mi constancia de estudio.
Criterios de Aceptacion:
• Veo mi nivel de perfil actual y cuántos XP me faltan para el siguiente.
• Veo el leaderboard semanal con aprendices de mi mismo programa.
• El leaderboard se actualiza en tiempo real y se reinicia cada lunes.
• Veo mi heatmap de días activos con al menos los últimos 3 meses.
• Veo gráfica comparativa de puntajes entre sesiones.
• Recibo notificación cuando subo de nivel de perfil.
