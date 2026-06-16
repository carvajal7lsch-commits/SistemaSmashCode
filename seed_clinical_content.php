<?php
/**
 * seed_clinical_content.php
 * Script para poblar la base de datos con contenido clínico real para el Nivel 1 / RAP 1.
 */

require_once 'config/sesion.php';
require_once 'includes/funciones.php';
require_once 'config/conexion.php';
require_once 'app/Core/Autoloader.php';
App\Core\Autoloader::registrar();

$pdo = obtenerConexion();

try {
    // 1. Obtener ID del primer RAP (Nivel 1)
    $stmt = $pdo->query("SELECT r.id FROM rap r JOIN nivel n ON r.nivel_id = n.id ORDER BY n.orden LIMIT 1");
    $rapId = $stmt->fetchColumn();

    if (!$rapId) {
        throw new Exception("No se encontró ningún RAP en la base de datos. Ejecuta primero smash_code.sql.");
    }

    echo "Poblando contenido clínico para RAP ID: {$rapId}...\n";

    // Iniciar transacción
    $pdo->beginTransaction();

    // Limpiar contenido anterior para este RAP
    $pdo->prepare("DELETE FROM respuesta_quiz WHERE pregunta_id IN (SELECT id FROM pregunta WHERE quiz_id IN (SELECT id FROM quiz WHERE rap_id = ?))")->execute([$rapId]);
    $pdo->prepare("DELETE FROM intento_quiz WHERE quiz_id IN (SELECT id FROM quiz WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM pregunta WHERE quiz_id IN (SELECT id FROM quiz WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM quiz WHERE rap_id = ?")->execute([$rapId]);
    $pdo->prepare("DELETE FROM intento_ejercicio WHERE ejercicio_id IN (SELECT id FROM ejercicio WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM ejercicio_opcion WHERE ejercicio_id IN (SELECT id FROM ejercicio WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM ejercicio WHERE rap_id = ?")->execute([$rapId]);
    $pdo->prepare("DELETE FROM turno_dialogo WHERE dialogo_id IN (SELECT id FROM dialogo WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM dialogo WHERE rap_id = ?")->execute([$rapId]);
    $pdo->prepare("DELETE FROM vocabulario_marcado WHERE vocabulario_id IN (SELECT id FROM vocabulario WHERE rap_id = ?)")->execute([$rapId]);
    $pdo->prepare("DELETE FROM vocabulario WHERE rap_id = ?")->execute([$rapId]);

    // Obtener IDs de categorías gramaticales
    $stmtCat = $pdo->query("SELECT id, nombre FROM categoria_vocabulario");
    $cats = [];
    while ($r = $stmtCat->fetch()) {
        $cats[strtolower($r['nombre'])] = $r['id'];
    }

    // Obtener IDs de áreas clínicas
    $stmtArea = $pdo->query("SELECT id, nombre FROM area_clinica");
    $areas = [];
    while ($r = $stmtArea->fetch()) {
        $areas[strtolower($r['nombre'])] = $r['id'];
    }

    $sustantivoId = $cats['sustantivo'] ?? null;
    $verboId = $cats['verbo'] ?? null;
    $fraseId = $cats['frase'] ?? null;
    $generalAreaId = $areas['general'] ?? null;

    // 2. Insertar Vocabulario
    $vocabEntries = [
        [
            'id' => generarUUID(),
            'termino_en' => 'Good morning',
            'termino_es' => 'Buenos días',
            'categoria_id' => $fraseId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/ɡʊd ˈmɔː.nɪŋ/',
            'oracion_ejemplo' => 'Good morning Mr. Smith, I am your nurse today.',
            'oracion_traduccion' => 'Buenos días Sr. Smith, soy su enfermero hoy.',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'Good afternoon',
            'termino_es' => 'Buenas tardes',
            'categoria_id' => $fraseId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/ɡʊd ˌɑːf.təˈnuːn/',
            'oracion_ejemplo' => 'Good afternoon, is the doctor in the office?',
            'oracion_traduccion' => 'Buenas tardes, ¿está el doctor en el consultorio?',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'Good evening',
            'termino_es' => 'Buenas noches',
            'categoria_id' => $fraseId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/ɡʊd ˈiːv.nɪŋ/',
            'oracion_ejemplo' => 'Good evening Mrs. Jones, time for your medication.',
            'oracion_traduccion' => 'Buenas noches Sra. Jones, hora de su medicamento.',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'First name',
            'termino_es' => 'Primer nombre',
            'categoria_id' => $sustantivoId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/fɜːst neɪm/',
            'oracion_ejemplo' => 'Please write your first name on the admission form.',
            'oracion_traduccion' => 'Por favor escriba su primer nombre en el formulario de admisión.',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'Last name',
            'termino_es' => 'Apellido',
            'categoria_id' => $sustantivoId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/lɑːst neɪm/',
            'oracion_ejemplo' => 'My last name is spelled S-M-I-T-H.',
            'oracion_traduccion' => 'Mi apellido se deletrea S-M-I-T-H.',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'Telephone number',
            'termino_es' => 'Número de teléfono',
            'categoria_id' => $sustantivoId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/ˈtel.ɪ.fəʊn ˌnʌm.bə/',
            'oracion_ejemplo' => 'Can you give me your contact telephone number?',
            'oracion_traduccion' => '¿Puede darme su número de teléfono de contacto?',
            'nivel_dificultad' => 'Básico'
        ],
        [
            'id' => generarUUID(),
            'termino_en' => 'Email address',
            'termino_es' => 'Dirección de correo',
            'categoria_id' => $sustantivoId,
            'area_clinica_id' => $generalAreaId,
            'transcripcion_ipa' => '/ˈiː.meɪl əˌdres/',
            'oracion_ejemplo' => 'We will send the clinical results to your email address.',
            'oracion_traduccion' => 'Enviaremos los resultados clínicos a su dirección de correo electrónico.',
            'nivel_dificultad' => 'Básico'
        ]
    ];

    $stmtVoc = $pdo->prepare("INSERT INTO vocabulario (id, rap_id, termino_en, termino_es, categoria_id, area_clinica_id, transcripcion_ipa, oracion_ejemplo, nivel_dificultad, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    // Nota: la columna oracion_traduccion no existe en el script original de smash_code.sql, solo oracion_ejemplo.
    // Vamos a insertar la traducción de la oración concatenada en el campo oracion_ejemplo o ignorar la columna extra.
    // Revisemos la estructura de la tabla vocabulario en el SQL:
    // oracion_ejemplo  VARCHAR(500) NULL,
    // Así que vamos a concatenar: "Ejemplo: Good morning... (Traducción: Buenos días...)" en oracion_ejemplo.
    foreach ($vocabEntries as $v) {
        $ejemploCompleto = $v['oracion_ejemplo'] . " (Español: " . $v['oracion_traduccion'] . ")";
        $stmtVoc->execute([
            $v['id'],
            $rapId,
            $v['termino_en'],
            $v['termino_es'],
            $v['categoria_id'],
            $v['area_clinica_id'],
            $v['transcripcion_ipa'],
            $ejemploCompleto,
            $v['nivel_dificultad']
        ]);
    }

    // 3. Insertar Diálogo Clínico
    $dialogoId = generarUUID();
    $stmtDia = $pdo->prepare("INSERT INTO dialogo (id, rap_id, titulo, contexto, participantes, activo) VALUES (?, ?, ?, ?, ?, 1)");
    $stmtDia->execute([
        $dialogoId,
        $rapId,
        'Patient Registration',
        'Nurse Sarah registers Mr. John Smith at the hospital admission desk.',
        'Nurse Sarah (Nurse) & Mr. John Smith (Patient)'
    ]);

    $turnos = [
        [
            'id' => generarUUID(),
            'dialogo_id' => $dialogoId,
            'orden_turno' => 1,
            'hablante' => 'Nurse Sarah',
            'texto_en' => 'Good morning, I am Sarah. What is your first name?',
            'texto_es' => 'Buenos días, soy Sarah. ¿Cuál es su primer nombre?'
        ],
        [
            'id' => generarUUID(),
            'dialogo_id' => $dialogoId,
            'orden_turno' => 2,
            'hablante' => 'Mr. John Smith',
            'texto_en' => 'Good morning, Nurse. My first name is John, and my last name is Smith.',
            'texto_es' => 'Buenos días, enfermera. Mi primer nombre es John y mi apellido es Smith.'
        ],
        [
            'id' => generarUUID(),
            'dialogo_id' => $dialogoId,
            'orden_turno' => 3,
            'hablante' => 'Nurse Sarah',
            'texto_en' => 'Nice to meet you, Mr. Smith. What is your telephone number?',
            'texto_es' => 'Gusto en conocerlo, Sr. Smith. ¿Cuál es su número de teléfono?'
        ],
        [
            'id' => generarUUID(),
            'dialogo_id' => $dialogoId,
            'orden_turno' => 4,
            'hablante' => 'Mr. John Smith',
            'texto_en' => 'Nice to meet you too. My telephone number is 555-0192, and my email is john.smith@email.com.',
            'texto_es' => 'Gusto en conocerla también. Mi número de teléfono es 555-0192 y mi correo es john.smith@email.com.'
        ]
    ];

    $stmtTur = $pdo->prepare("INSERT INTO turno_dialogo (id, dialogo_id, orden_turno, hablante, texto_en, texto_es) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($turnos as $t) {
        $stmtTur->execute([
            $t['id'],
            $t['dialogo_id'],
            $t['orden_turno'],
            $t['hablante'],
            $t['texto_en'],
            $t['texto_es']
        ]);
    }

    // 4. Insertar Ejercicios
    $ejercicios = [
        [
            'id' => generarUUID(),
            'tipo' => 'seleccion_multiple',
            'enunciado' => 'Complete the sentence: "Good morning, I ___ Nurse Sarah."',
            'opciones' => [
                ['texto' => 'am', 'es_correcta' => 1, 'retro' => '¡Correcto! "I am" se utiliza con la primera persona del singular.'],
                ['texto' => 'is', 'es_correcta' => 0, 'retro' => '"is" se usa para tercera persona (he/she/it).'],
                ['texto' => 'are', 'es_correcta' => 0, 'retro' => '"are" se usa para you/we/they.']
            ]
        ],
        [
            'id' => generarUUID(),
            'tipo' => 'completar_frase',
            'enunciado' => 'Complete the sentence: "What is your telephone ___?"',
            'opciones' => [
                ['texto' => 'number', 'es_correcta' => 1, 'retro' => '¡Correcto! "Telephone number" es la combinación correcta.'],
                ['texto' => 'email', 'es_correcta' => 0, 'retro' => '"Telephone email" no tiene sentido clínico.'],
                ['texto' => 'first', 'es_correcta' => 0, 'retro' => '"Telephone first" no es la estructura adecuada.']
            ]
        ],
        [
            'id' => generarUUID(),
            'tipo' => 'arrastrar_soltar',
            'enunciado' => 'Match English terms with their Spanish meanings.',
            'opciones' => [
                ['texto' => 'Good morning = Buenos días', 'es_correcta' => 1, 'retro' => '¡Correcto!'],
                ['texto' => 'Last name = Apellido', 'es_correcta' => 1, 'retro' => '¡Correcto!'],
                ['texto' => 'First name = Primer nombre', 'es_correcta' => 1, 'retro' => '¡Correcto!']
            ]
        ],
        [
            'id' => generarUUID(),
            'tipo' => 'ordenar_dialogo',
            'enunciado' => 'Put this simple patient greeting in order:',
            'opciones' => [
                ['texto' => '1. Good morning, Nurse Sarah. | 2. Good morning Mr. Smith. | 3. How are you today? | 4. I am feeling good.', 'es_correcta' => 1, 'retro' => '¡Excelente! Has ordenado la conversación correctamente.']
            ]
        ],
        [
            'id' => generarUUID(),
            'tipo' => 'escucha_escribe',
            'enunciado' => 'Type the word you hear (greetings): "morning"',
            'opciones' => [
                ['texto' => 'morning', 'es_correcta' => 1, 'retro' => '¡Correcto! "morning" significa mañana.'],
                ['texto' => 'good morning', 'es_correcta' => 1, 'retro' => '¡Correcto!']
            ]
        ],
        [
            'id' => generarUUID(),
            'tipo' => 'role_play',
            'enunciado' => 'Patient: "Good afternoon nurse, my arm hurts." What is the best and most empathetic response?',
            'opciones' => [
                ['texto' => 'Good afternoon. I am sorry to hear that. Let me call the doctor.', 'es_correcta' => 1, 'retro' => '¡Excelente! Es empático y profesional.'],
                ['texto' => 'Good afternoon. I don\'t care, wait in the lobby.', 'es_correcta' => 0, 'retro' => 'No es una respuesta empática.'],
                ['texto' => 'Hello. Go home.', 'es_correcta' => 0, 'retro' => 'No es profesional.']
            ]
        ]
    ];

    $stmtEj = $pdo->prepare("INSERT INTO ejercicio (id, rap_id, tipo, enunciado, max_intentos, puntos, activo) VALUES (?, ?, ?, ?, 3, 10, 1)");
    $stmtOpc = $pdo->prepare("INSERT INTO ejercicio_opcion (id, ejercicio_id, texto, es_correcta, retroalimentacion) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($ejercicios as $ej) {
        $stmtEj->execute([
            $ej['id'],
            $rapId,
            $ej['tipo'],
            $ej['enunciado']
        ]);

        foreach ($ej['opciones'] as $opc) {
            $stmtOpc->execute([
                generarUUID(),
                $ej['id'],
                $opc['texto'],
                $opc['es_correcta'],
                $opc['retro']
            ]);
        }
    }

    // 5. Insertar Quiz
    $quizId = generarUUID();
    $stmtQuiz = $pdo->prepare("INSERT INTO quiz (id, rap_id, puntaje_minimo, limite_tiempo_seg, aleatorizar, max_intentos, activo) VALUES (?, ?, 60.00, 300, 0, 3, 1)");
    $stmtQuiz->execute([
        $quizId,
        $rapId
    ]);

    $preguntas = [
        [
            'texto' => 'Which subject + verb configuration is correct?',
            'opciones' => json_encode(['I are', 'I is', 'I am', 'She am']),
            'respuesta_correcta' => 'I am',
            'retroalimentacion' => 'El verbo To Be para "I" (yo) es "am".'
        ],
        [
            'texto' => 'Which greeting is appropriate for 3:00 PM?',
            'opciones' => json_encode(['Good morning', 'Good afternoon', 'Good evening', 'Good night']),
            'respuesta_correcta' => 'Good afternoon',
            'retroalimentacion' => 'Se usa "Good afternoon" desde el mediodía hasta el atardecer (alrededor de las 6:00 PM).'
        ],
        [
            'texto' => 'How do you translate "Apellido" to English?',
            'opciones' => json_encode(['First name', 'Last name', 'Telephone number', 'Email']),
            'respuesta_correcta' => 'Last name',
            'retroalimentacion' => '"Last name" o "Surname" es la traducción de Apellido.'
        ],
        [
            'texto' => 'How is "S-M-I-T-H" spelled?',
            'opciones' => json_encode(['Smith', 'Smyth', 'Smoth', 'Smithy']),
            'respuesta_correcta' => 'Smith',
            'retroalimentacion' => 'Las letras corresponden al apellido Smith.'
        ],
        [
            'texto' => 'Complete: "The patient\'s email ___ is john@email.com."',
            'opciones' => json_encode(['number', 'first name', 'address', 'last name']),
            'respuesta_correcta' => 'address',
            'retroalimentacion' => '"Email address" es la forma correcta para dirección de correo.'
        ]
    ];

    $stmtPreg = $pdo->prepare("INSERT INTO pregunta (id, quiz_id, texto, opciones, respuesta_correcta, retroalimentacion) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($preguntas as $p) {
        $stmtPreg->execute([
            generarUUID(),
            $quizId,
            $p['texto'],
            $p['opciones'],
            $p['respuesta_correcta'],
            $p['retroalimentacion']
        ]);
    }

    $pdo->commit();
    echo "\n¡Se ha poblado con éxito la base de datos con contenido del RAP 1!\n";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "\nError al poblar: " . $e->getMessage() . "\n";
}
