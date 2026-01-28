<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --danger: #ef4444;
            --success: #10b981;
            --bg: #f1f5f9;
            --sidebar: #1e293b;
            --card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; display: flex; }

        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar); height: 100vh; color: white; position: fixed; padding: 1.5rem; }
        .sidebar h2 { color: #818cf8; font-size: 1.5rem; margin-bottom: 2rem; }
        .nav-link { display: flex; align-items: center; gap: 12px; color: #94a3b8; text-decoration: none; padding: 12px; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: #334155; color: white; }

        /* Main Content */
        .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid var(--primary); }
        .stat-card h3 { margin: 0; color: var(--text-muted); font-size: 0.9rem; }
        .stat-card p { margin: 10px 0 0; font-size: 1.8rem; font-weight: 800; color: var(--text-main); }

        /* Tables */
        .data-card { background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; margin-bottom: 2rem; }
        .card-header { padding: 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 12px 1.5rem; text-align: left; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 12px 1.5rem; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        /* Badges & Buttons */
        .badge { padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; }
        .badge-geo { background: #e0e7ff; color: var(--primary); }
        .btn-action { padding: 6px; border-radius: 6px; border: none; cursor: pointer; transition: 0.2s; }
        .btn-delete { background: #fee2e2; color: var(--danger); }
        .btn-delete:hover { background: var(--danger); color: white; }

        .search-box { padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 8px; width: 300px; }
    </style>
</head>
<body>

@auth
    @if(Auth::user()->role === 'admin')
        <div class="sidebar">
            <h2><i class="fa-solid fa-shield-halved"></i> QC Admin</h2>
            <a href="#" class="nav-link active"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            <a href="#questions" class="nav-link"><i class="fa-solid fa-message"></i> Questions</a>
            <a href="#responses" class="nav-link"><i class="fa-solid fa-comments"></i> Réponses</a>
            <a href="/logout" class="nav-link" style="margin-top: auto; color: #f87171;"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Tableau de Bord</h1>
                <div class="user-info-top">
                    <span style="font-weight: 600;">Bienvenue, {{ Auth::user()->fullname }}</span>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Questions</h3>
                    <p>{{ $totalQuestions ?? '124' }}</p>
                </div>
                <div class="stat-card" style="border-left-color: var(--success);">
                    <h3>Total Réponses</h3>
                    <p>{{ $totalReplies ?? '458' }}</p>
                </div>
                <div class="stat-card" style="border-left-color: #f59e0b;">
                    <h3>Plus Populaire</h3>
                    <p style="font-size: 1rem; margin-top: 15px;">{{ $popularQuestion->titre ?? 'Panne d\'électricité...' }}</p>
                </div>
            </div>

            <div class="data-card" id="questions">
                <div class="card-header">
                    <h2 style="font-size: 1.1rem;">Gestion des Questions</h2>
                    <input type="text" class="search-box" placeholder="Rechercher par mot-clé ou lieu...">
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Question</th>
                        <th>Localisation</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                  {{--le probleme ici --}}  @foreach($questions as $question)
                        <tr>
                            <td><strong>{{ $question->user->fullname }}</strong></td>
                            <td>{{ Str::limit($question->titre, 40) }}</td>
                            <td><span class="badge badge-geo"><i class="fa-solid fa-location-dot"></i> {{ $question->city }}</span></td>
                            <td>{{ $question->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('admin.questions.delete', $question->id) }}" method="POST" onsubmit="return confirm('Supprimer cette question ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="data-card" id="responses">
                <div class="card-header">
                    <h2 style="font-size: 1.1rem;">Gestion des Réponses</h2>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Réponse</th>
                        <th>Sur la question</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allReplies as $reply)
                        <tr>
                            <td>{{ $reply->user->fullname }}</td>
                            <td style="color: var(--text-muted);">{{ Str::limit($reply->message, 50) }}</td>
                            <td>{{ Str::limit($reply->question->titre, 30) }}</td>
                            <td>
                                <form action="{{ route('admin.replies.delete', $reply->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn-action btn-delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div style="text-align: center; margin-top: 100px;">
            <h1>403 - Accès Interdit</h1>
            <p>Désolé, seul l'administrateur peut accéder à cette page.</p>
            <a href="/home">Retour à l'accueil</a>
        </div>
    @endif
@endauth

</body>
</html>
