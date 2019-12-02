<?
require_once 'util/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/global.css">
    <title>Le Cuisineur - Inscription</title>
</head>

<body>
    <? include_once 'parts/header.php' ?>
    <form id="inscription" class="inscription" action="/membre/new" method="post">
        <fieldset>
            <div class="inscription__row">
                <label for="login">Nom d'utilisateur</label>
                <input name="login" minlength="4" maxlength="16" type="text" required>
            </div>
            <div class="inscription__row">
                <label for="email">Email</label>
                <input name="email" type="email" required>
            </div>
            <div class="inscription__row">
                <label for="password">Mot de passe</label>
                <input name="password" minlength="8" type="password" required>
            </div>
            <div class="inscription__row">
                <label for="nom">Nom</label>
                <input name="nom" type="text" required>
            </div>
            <div class="inscription__row">
                <label for="prenom">Prenom</label>
                <input name="prenom" type="text" required>
            </div>
            <button id="inscriptionSubmit" type="submit" disabled>Envoyer</button>
        </fieldset>
        <div id="inscriptionFeedback"></div>
    </form>
</body>
<script>
    // formulaire
    const inscriptionForm = document.getElementById("inscription");
    // boutton d'envoi
    const sendBtn = document.getElementById("inscriptionSubmit");
    // champs de reponse
    const feedbackElement = document.getElementById("inscriptionFeedback");

    document.addEventListener("DOMContentLoaded", e => {
        inscription.addEventListener("submit", handleSending);
        sendBtn.disabled = false;
    });

    function handleSending(e) {
        e.preventDefault();
        fetch(inscriptionForm.action, {
                method: 'post',
                body: new FormData(inscriptionForm),
                cache: 'no-cache',
            })
            .then(json => json.json())
            .then(rsp => {
                if (rsp.success == true)
                    window.location.pathname = "/";
                else {
                    feedbackElement.innerText = rsp.message;
                }
            });
    }
</script>