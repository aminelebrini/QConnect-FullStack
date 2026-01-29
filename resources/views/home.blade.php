<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'QConnect' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --bg: #fdfdfd;
            --card: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        .card {
            background: var(--card);
            padding: 48px;
            border-radius: 32px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.03);
            position: relative;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: #eef2ff;
            color: var(--primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            transform: rotate(-10deg);
        }

        h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .subtitle {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 32px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            margin-left: 4px;
        }

        input {
            width: 100%;
            padding: 14px 20px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 16px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 18px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .switch-text {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: var(--muted);
        }

        .switch-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .hidden { display: none; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate { animation: slideIn 0.4s ease forwards; }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="card">

        <div id="login-form" class="animate">
            <div class="logo-section">
                <div class="icon-circle">
                    <i class="fas fa-street-view"></i>
                </div>
                <h1>Bienvenue</h1>
                <p class="subtitle">Connectez-vous pour voir ce qui se passe à proximité.</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="amine@exemple.com" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Se connecter</button>
            </form>

            <p class="switch-text">Nouveau ici ? <a href="javascript:void(0)" onclick="toggleAuth()">Rejoindre le quartier</a></p>
        </div>

        <div id="register-form" class="hidden">
            <div class="logo-section">
                <div class="icon-circle">
                    <i class="fas fa-map-pin"></i>
                </div>
                <h1>Inscription</h1>
                <p class="subtitle">Créez votre profil pour aider vos voisins.</p>
            </div>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="input-group">
                    <label>Nom complet</label>
                    <input type="text" name="full_name" placeholder="Amine ..." required>
                </div>
                <div class="input-group">
                    <label>Ville</label>
                    <input type="text" name="city" placeholder="Ex: Lille" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="amine@exemple.com" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Créer le compte</button>
            </form>

            <p class="switch-text">Déjà un compte ? <a href="javascript:void(0)" onclick="toggleAuth()">Me connecter</a></p>
        </div>

    </div>
</div>

<script>
    function toggleAuth() {
        const login = document.getElementById('login-form');
        const register = document.getElementById('register-form');

        if (login.classList.contains('hidden')) {
            login.classList.remove('hidden');
            login.classList.add('animate');
            register.classList.add('hidden');
        } else {
            login.classList.add('hidden');
            register.classList.remove('hidden');
            register.classList.add('animate');
        }
    }
</script>
</body>
</html>
