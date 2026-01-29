<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QConnect - Dashboard</title>
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

        .side-dash {
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

        .side-logo {
            font-weight: 800;
            font-size: 22px;
            color: #0f172a;
            text-decoration: none;
            margin-bottom: 48px;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -1px;
        }

        .side-logo i {
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
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            font-family: inherit;
            font-size: 14px;
        }

        .nav-link:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        main {
            margin-left: var(--side-width);
            flex: 1;
            padding-bottom: 80px;
        }

        header {
            padding: 24px 5%;
            display: flex;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(8px);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .page-header {
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

        .question-card {
            background: var(--card);
            border-radius: 32px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.2s;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-box {
            width: 44px; height: 44px;
            background: var(--primary-soft);
            color: var(--primary);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
        }

        .user-name { font-weight: 700; font-size: 15px; color: #0f172a; }
        .time-ago { font-size: 12px; color: var(--muted); }

        .location-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            color: var(--primary);
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .question-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .card-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .btn-action {
            padding: 10px 20px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid var(--border);
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-action:hover { background: #f8fafc; border-color: var(--primary); color: var(--primary); }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .comment-box {
            margin-top: 20px;
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
        }

        .comment-item {
            display: flex; gap: 12px; margin-bottom: 15px;
        }

        .mini-avatar {
            width: 32px; height: 32px; background: white; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800;
        }

        .reply-input-wrap {
            display: flex; gap: 10px; background: white; padding: 8px; border-radius: 16px; border: 1px solid var(--border);
        }

        .reply-input-wrap input {
            flex: 1; border: none; padding: 8px; outline: none; font-family: inherit; font-size: 13px;
        }

        .search-input {
            padding: 12px 20px; background: white; border: 1px solid var(--border);
            border-radius: 16px; width: 240px; font-family: inherit;
        }

        .modal { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(8px); z-index: 2000; }
        .modal-content { background: white; margin: 10vh auto; padding: 40px; border-radius: 32px; width: 90%; max-width: 500px; }

        .field { width: 100%; padding: 14px; border: 1px solid var(--border); border-radius: 14px; margin-bottom: 16px; font-family: inherit; background: #f8fafc; }

        .btn-icon { width: 36px; height: 36px; border-radius: 10px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .btn-delete { background: #fee2e2; color: #ef4444; }
        .btn-edit { background: var(--primary-soft); color: var(--primary); }

        .favoris-container { display: none; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        .animate-up { animation: fadeInUp 0.4s ease forwards; }
    </style>
</head>
<body>

@auth
    <aside class="side-dash">
        <a href="#" class="side-logo">
            <i class="fa-solid fa-street-view"></i> QConnect
        </a>

        <nav style="flex: 1">
            <button onclick="showSection('discover')" class="nav-link active" id="link-discover">
                <i class="fa-solid fa-house"></i> Découvrir
            </button>
            <button onclick="showSection('favoris')" class="nav-link" id="link-favoris">
                <i class="fa-solid fa-star"></i> Mes Favoris
            </button>
        </nav>

        <div style="padding-top: 20px; border-top: 1px solid var(--border)">
            <div class="nav-link" style="cursor: default">
                <div class="mini-avatar" style="background: var(--primary-soft); color: var(--primary); font-size:22px">{{ substr(Auth::user()->fullname, 0, 1) }}</div>
                <span style="color: #0f172a">{{ Auth::user()->fullname }}</span>
            </div>
            <a href="/logout" class="nav-link" style="color: #ef4444">
                <i class="fa-solid fa-power-off"></i> Déconnexion
            </a>
        </div>
    </aside>

    <main>
        <header>
            <button onclick="openModal('postModal')" class="btn-primary">
                <i class="fa-solid fa-plus"></i> Poser une question
            </button>
        </header>

        <div class="container">
            <div class="page-header">
                <h1 id="pageTitle">Découvrir</h1>
                <form method="GET" action="{{ route('affichage') }}">
                    <input type="text" name="search" placeholder="Rechercher une ville..." class="search-input">
                </form>
            </div>

            <div id="questionsFeed">
                @foreach($questions as $question)
                    <div class="question-card animate-up">
                        <div class="question-header">
                            <div class="user-meta">
                                <div class="avatar-box"><i class="fa-solid fa-user"></i></div>
                                <div>
                                    <div class="user-name">{{ $question->user->fullname }}</div>
                                    <div class="time-ago">{{ $question->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @if($question->user_id === Auth::id())
                                <div style="display:flex; gap:8px">
                                    <button onclick="openEditModal('{{ $question->id }}', '{{ addslashes($question->titre) }}', '{{ addslashes($question->city) }}', '{{ addslashes($question->description) }}')" class="btn-icon btn-edit"><i class="fa-solid fa-pen"></i></button>
                                    <form action="{{ route('question.delete')}}" method="POST">@csrf<input type="hidden" name="questionid" value="{{ $question->id }}"><button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-trash"></i></button></form>
                                </div>
                            @endif
                        </div>

                        <div class="location-badge"><i class="fa-solid fa-location-dot"></i> {{ $question->city }}</div>
                        <h2 class="question-title">{{ $question->titre }}</h2>
                        <p style="color: var(--muted); line-height: 1.6">{{ $question->description }}</p>

                        <div class="card-actions">
                            <div class="btn-action" style="border:none; background: var(--primary-soft); color: var(--primary)">
                                <i class="fa-regular fa-comment"></i> {{ $question->reponses->count() }}
                            </div>
                            <form method="POST" action="{{ route('favoris.store') }}">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                <button type="submit" class="btn-action"><i class="fa-regular fa-star"></i> Sauvegarder</button>
                            </form>
                        </div>

                        <div class="comment-box">
                            @foreach($question->reponses as $reply)
                                <div class="comment-item">
                                    <div class="mini-avatar">{{ substr($reply->user->fullname, 0, 1) }}</div>
                                    <div style="background: white; padding: 12px 16px; border-radius: 0 16px 16px 16px; border: 1px solid var(--border); flex: 1">
                                        <div style="font-size: 12px; font-weight: 800; margin-bottom: 4px">{{ $reply->user->fullname }}</div>
                                        <div style="font-size: 13px; color: var(--muted)">{{ $reply->content }}</div>
                                    </div>
                                </div>
                            @endforeach

                            @if($question->user_id !== Auth::id())
                                <form action="{{ route('reponses.store') }}" method="POST" class="reply-input-wrap">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                    <input type="text" name="message" placeholder="Votre réponse..." required>
                                    <button type="submit" style="background: var(--primary); color:white; border:none; width:32px; height:32px; border-radius:10px; cursor:pointer"><i class="fa-solid fa-paper-plane"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="favorisSection" class="favoris-container">
                @foreach($favoris as $fav)
                    <div class="question-card animate-up" style="border-left: 6px solid #fbbf24">
                        <div class="question-header">
                            <h3 class="question-title">{{ $fav->question->titre }}</h3>
                            <form action="{{ route('favoris.delete')}}" method="POST">@csrf<input type="hidden" name="favid" value="{{ $fav->id }}"><button type="submit" class="btn-icon btn-delete"><i class="fa-solid fa-xmark"></i></button></form>
                        </div>
                        <p style="color: var(--muted); font-size: 14px">{{ Str::limit($fav->question->description, 100) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <div id="postModal" class="modal">
        <div class="modal-content animate-up">
            <h2 style="font-weight: 800; margin-bottom: 24px">Nouvelle question</h2>
            <form action="{{ route('questions') }}" method="POST">
                @csrf
                <label style="font-size:13px; font-weight:700; margin-bottom:8px; display:block">Sujet</label>
                <input type="text" name="titre" class="field" required>
                <label style="font-size:13px; font-weight:700; margin-bottom:8px; display:block">Ville</label>
                <input type="text" name="city" class="field" required>
                <label style="font-size:13px; font-weight:700; margin-bottom:8px; display:block">Description</label>
                <textarea name="description" rows="5" class="field" required></textarea>
                <div style="display:flex; gap:12px">
                    <button type="submit" class="btn-primary" style="flex:1">Publier</button>
                    <button type="button" onclick="closeModal('postModal')" class="btn-action" style="flex:1; justify-content:center">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editForm" class="modal">
        <div class="modal-content animate-up">
            <h2 style="font-weight: 800; margin-bottom: 24px">Modifier</h2>
            <form action="{{ route('question.update') }}" method="POST">
                @csrf
                <input type="hidden" name="question_id" id="question_id">
                <input type="text" name="titre" id="editTitreInput" class="field" required>
                <input type="text" name="city" id="editcity" class="field" required>
                <textarea name="description" id="editDescInput" rows="5" class="field" required></textarea>
                <div style="display:flex; gap:12px">
                    <button type="submit" class="btn-primary" style="flex:1">Enregistrer</button>
                    <button type="button" onclick="closeModal('editForm')" class="btn-action" style="flex:1; justify-content:center">Fermer</button>
                </div>
            </form>
        </div>
    </div>
@endauth

<script>
    function openModal(id) { document.getElementById(id).style.display = 'block'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    window.onclick = function(e) { if(e.target.classList.contains('modal')) closeModal(e.target.id); }

    function showSection(id) {
        const feed = document.getElementById('questionsFeed');
        const favs = document.getElementById('favorisSection');
        const title = document.getElementById('pageTitle');
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

        if(id === 'favoris') {
            feed.style.display = 'none'; favs.style.display = 'block';
            title.innerText = 'Mes Favoris';
            document.getElementById('link-favoris').classList.add('active');
        } else {
            feed.style.display = 'block'; favs.style.display = 'none';
            title.innerText = 'Découvrir';
            document.getElementById('link-discover').classList.add('active');
        }
    }

    function openEditModal(id, titre, city, desc) {
        document.getElementById('question_id').value = id;
        document.getElementById('editTitreInput').value = titre;
        document.getElementById('editcity').value = city;
        document.getElementById('editDescInput').value = desc;
        openModal('editForm');
    }
</script>
</body>
</html>
