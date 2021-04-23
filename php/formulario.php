<?php

/*  isset - Determina si una variable está definida y no es null
    empty- Determina si una variable está vacia
    trim - Elimina espacios en blanco (u otro tipo de caracteres) del inicio y el final de la cadena*/

if ($_POST) {
    $name = "";
    $mail = "";
    $message = "";

    if (isset($_POST['name'])) {
        $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['message'])) {
        $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);
    }

    if (isset($_POST['mail'])) {
        $mail = filter_var(trim($_POST['mail']), FILTER_VALIDATE_EMAIL);
    }

    if (empty($name)) {
        echo json_encode(array(
            'error' => true,
            'input' => 'name'
        ));
        return;
    }

    if (empty($mail)) {
        echo json_encode(array(
            'error' => true,
            'input' => 'mail'
        ));
        return;
    }

    if (empty($message)) {
        echo json_encode(array(
            'error' => true,
            'input' => 'message'
        ));
        return;
    }

    //Cuerpo del mensaje
    $body = 'User: ' . $name . '<br>';
    $body .= 'Mail: ' . $mail . '<br>';
    $body .= 'Message: ' . $message . '<br>';

    //Destinatario
    $correoPersonal = 'juanpix2404@gmail.com'; //Se reemplaza por el correo a usar en la empresa
    $asunto = 'Mensaje del sitio web';

    // Para que acepte correo con HTML
    $headers  = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n" . 'From: ' . $mail . "\r\n";

    if (mail($correoPersonal, $asunto, $body, $headers)) {

        echo json_encode(array(
            'error' => false,
            'input' => 'successful'
        ));
    } else {
        echo json_encode(array(
            'error' => true,
            'input' => 'mail'
        ));
    }
} else {

    echo json_encode(array(
        'error' => true,
        'input' => 'post'
    ));
}
