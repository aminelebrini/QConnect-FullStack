<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --bg: #fdfdfd;
            --card: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --border: #f1f5f9;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            --side-width: 280px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .sidebar {
            width: var(--side-width);
            background: var(--card);
            border-right: 1px solid var(--border);
            padding: 40px 24px;
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar h2 {
            font-weight: 800;
            font-size: 22px;
            color: #0f172a;
            margin-bottom: 48px;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -1px;
        }

        .sidebar h2 i {
            color: var(--primary);
            transform: rotate(-10deg);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            text-decoration: none;
            color: var(--muted);
            font-weight: 600;
            border-radius: 16px;
            transition: all 0.2s;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .main-content {
            margin-left: var(--side-width);
            flex: 1;
            padding: 40px 5%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #0f172a;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card);
            padding: 32px;
            border-radius: 32px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card p {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -1px;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 6px; height: 100%;
            background: var(--primary);
        }

        .data-card {
            background: var(--card);
            border-radius: 32px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.02);
            overflow: hidden;
            margin-bottom: 40px;
            padding: 24px;
        }

        .card-header {
            padding: 12px 12px 24px 12px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 12px;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        th {
            padding: 12px 20px;
            text-align: left;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        td {
            padding: 16px 20px;
            background: #f8fafc;
            font-size: 14px;
        }

        td:first-child { border-radius: 16px 0 0 16px; }
        td:last-child { border-radius: 0 16px 16px 0; }

        .badge-geo {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 12px;
        }

        .forbidden-wrap {
            text-align: center;
            margin-top: 15vh;
            padding: 40px;
        }

        .btn-home {
            display: inline-block;
            margin-top: 24px;
            padding: 14px 28px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 18px;
            font-weight: 700;
            transition: 0.2s;
        }

        .btn-home:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); }
    </style>
</head>
<body>

@auth
    @if(Auth::user()->role === 'admin')
        <div class="sidebar">
            <h2><i class="fa-solid fa-shield-halved"></i> Admin</h2>
            <nav style="flex: 1">
                <a href="#" class="nav-link active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                <a href="#questions" class="nav-link"><i class="fa-solid fa-message"></i> Questions</a>
                <a href="#responses" class="nav-link"><i class="fa-solid fa-comments"></i> Réponses</a>
            </nav>
            <a href="/logout" class="nav-link" style="color: #ef4444; border-top: 1px solid var(--border); padding-top: 20px; margin-top: 20px;">
                <i class="fa-solid fa-power-off"></i> Déconnexion
            </a>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Vue d'ensemble</h1>
                <div class="user-meta" style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-weight: 700;">{{ Auth::user()->fullname }}</span>
                    <div style="width: 40px; height: 40px; background: var(--primary-soft); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary)">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Questions</h3>
                    <p>{{ count($questions) }}</p>
                </div>
                <div class="stat-card" style="border-left-color: #10b981;">
                    <h3>Réponses</h3>
                    <p>{{ count($reponses) }}</p>
                </div>
                <div class="stat-card" style="border-left-color: #fbbf24;">
                    <h3>Citoyens</h3>
                    <p>{{ count($users) }}</p>
                </div>
            </div>

            <div class="data-card" id="questions">
                <div class="card-header">
                    <h2>Dernières Questions</h2>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Titre</th>
                        <th>Ville</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td style="font-weight: 700;">{{ $question->user->fullname }}</td>
                            <td style="color: var(--muted);">{{ Str::limit($question->titre, 40) }}</td>
                            <td><span class="badge badge-geo"><i class="fa-solid fa-location-dot"></i> {{ $question->city }}</span></td>
                            <td>{{ $question->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="data-card" id="responses">
                <div class="card-header">
                    <h2>Modération des Réponses</h2>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Message</th>
                        <th>Sur la question</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reponses as $reply)
                        <tr>
                            <td style="font-weight: 700;">{{ $reply->user->fullname }}</td>
                            <td style="color: var(--muted); font-style: italic;">"{{ Str::limit($reply->content, 50) }}"</td>
                            <td style="font-weight: 600; color: var(--primary);">{{ Str::limit($reply->question->titre, 30) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="forbidden-wrap">
            <div style="font-size: 80px; color: var(--primary); margin-bottom: 20px; transform: rotate(-10deg)">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1>Accès Interdit</h1>
            <p style="color: var(--muted)">Désolé, seul l'administrateur peut accéder à cette zone.</p>
            <a href="/home" class="btn-home">Retour à l'accueil</a>
        </div>
    @endif
@endauth

</body>
</html>
