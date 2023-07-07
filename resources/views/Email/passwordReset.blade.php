<style>
    .email-body{
        margin-left: 5%;
    }
    .btn {
        padding: 10px 20px;
        background-color: #2d3748;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }
    .title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        margin-top: 30px;
    }
    .merci{
        margin-top: 30px;
    }
</style>

<div class="email-body">
    <div class="title">UBO</div>

    <p>Bonjour,</p>
    <p>Pour créer votre nouveau mot de passe, rien de plus simple ! Il vous suffit de cliquer sur ce bouton :</p>
    
    <div>
        <a href="http://localhost:{{ config('app.vue_port') }}/{{ $route }}/{{ $token }}" class="btn">
            Changer votre mot de passe
        </a>
    </div>
    
    <div class="merci">Merci,<br>Équipe UBO</div>
</div>