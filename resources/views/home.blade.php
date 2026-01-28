<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'QConnect - Authentification' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #6366f1;
            --text-dark: #111827;
            --white: #ffffff;
            --transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .container {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 550px;
        }

        /* --- Formulaires --- */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: var(--transition);
        }

        form {
            background-color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }

        h1 { font-weight: 800; margin-bottom: 10px; color: var(--primary); }

        .input-group { width: 100%; margin: 8px 0; }

        input {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 12px 15px;
            border-radius: 10px;
            width: 100%;
            font-size: 14px;
            outline: none;
        }

        button {
            border-radius: 50px;
            border: 1px solid var(--primary);
            background-color: var(--primary);
            color: var(--white);
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            margin-top: 15px;
            transition: transform 0.2s;
        }

        button:active { transform: scale(0.95); }

        /* --- Animation des panneaux --- */
        .sign-in-container { left: 0; width: 50%; z-index: 2; }
        .sign-up-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

        .container.right-panel-active .sign-in-container { transform: translateX(100%); }
        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        @keyframes show {
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        /* --- Overlay (Partie Bleue) --- */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: var(--transition);
            z-index: 100;
        }

        .container.right-panel-active .overlay-container { transform: translateX(-100%); }

        .overlay {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: var(--transition);
        }

        .container.right-panel-active .overlay { transform: translateX(50%); }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transition: var(--transition);
        }

        .overlay-panel h1 { color: white !important; font-size: 2rem; }
        .overlay-panel p {
            font-size: 14px;
            line-height: 1.6;
            margin: 0px 0 0px;
            color: rgba(255, 255, 255, 0.9);
        }

        .overlay-left { transform: translateX(-20%); }
        .container.right-panel-active .overlay-left { transform: translateX(0); }

        .overlay-right { right: 0; transform: translateX(0); }
        .container.right-panel-active .overlay-right { transform: translateX(20%); }

        /* Style bouton Ghost */
        button.ghost {
            background-color: transparent;
            border-color: var(--white);
            border-width: 2px;
        }

        button.ghost:hover {
            background: white;
            color: var(--primary);
        }

        /* Animation de l'icône */
        .bounce-icon {
            animation: bounce 3s ease-in-out infinite;
            margin-bottom: 10px;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>

<div class="container" id="container">

    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <h1>Créer un compte</h1>
            <div class="input-group">
                <input type="text" name="full_name" placeholder="Nom complet" required />
            </div>
            <div class="input-group">
                <input type="text" name="city" placeholder="City" required />
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Mot de passe" required />
            </div>
            <button type="submit">S'inscrire</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <h1>Connexion</h1>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Mot de passe" required />
            </div>
            <a href="#" style="font-size: 12px; color: #666; text-decoration: none; margin: 10px 0;">Mot de passe oublié ?</a>
            <button type="submit">Se connecter</button>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">

            <div class="overlay-panel overlay-left">
                <h1>Bon retour !</h1>
                <p>Déjà un compte ? Connecte-toi pour retrouver tes amis sur QConnect.</p>
                <button class="ghost" id="signIn">Se connecter</button>
            </div>

            <div class="overlay-panel overlay-right">
                <div class="bounce-icon">
                    <i class="fas fa-paper-plane fa-3x"></i>
                </div>
                <h1>Salut l'ami !</h1>
                <p>Rejoins <strong>QConnect</strong> aujourd'hui.<br>Crée ton compte et explore de nouveaux horizons avec nous !</p>
                <button class="ghost" id="signUp">S'inscrire</button>
            </div>

        </div>
    </div>
</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>

</body>
</html>
