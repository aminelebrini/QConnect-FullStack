<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QConnect - Communauté locale</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg: #f8fafc;
            --card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body { font-family: 'Inter', sans-serif; background-color: var(--bg); color: var(--text-main); margin: 0; padding: 0; }
        nav { background: white; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 100; }
        .logo { font-weight: 800; font-size: 1.5rem; color: var(--primary); text-decoration: none; }
        .container { max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }

        .btn-ask {
            background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none;
            font-weight: 600; transition: 0.3s; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px;
        }

        .question-card {
            background: var(--card); border-radius: 16px; padding: 1.5rem; margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;
        }

        /* --- Section Réponses --- */
        .replies-section { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9; }

        .reply-item {
            background: #f8fafc; padding: 12px; border-radius: 10px; margin-bottom: 10px; border-left: 3px solid var(--primary);
        }
        .reply-user { font-weight: 700; font-size: 0.85rem; color: var(--text-main); }
        .reply-text { font-size: 0.9rem; color: var(--text-muted); margin-top: 4px; }

        .reply-form { margin-top: 15px; display: flex; gap: 10px; }
        .reply-input {
            flex: 1; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 20px; outline: none; transition: 0.2s;
        }
        .reply-input:focus { border-color: var(--primary); }
        .btn-reply {
            background: var(--primary); color: white; border: none; padding: 8px 15px; border-radius: 20px;
            cursor: pointer; font-weight: 600; font-size: 0.85rem;
        }

        /* Styles existants pour l'avatar et modal... */
        .avatar { width: 45px; height: 45px; background: #eef2ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); }
        .user-info h4 { margin: 0; font-size: 1rem; }
        .location-tag { display: inline-flex; align-items: center; gap: 6px; background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; }

        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); }
        .modal-content { background-color: white; margin: 5% auto; padding: 2.5rem; border-radius: 16px; width: 90%; max-width: 500px; position: relative; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: var(--primary); color: white; border: none; padding: 14px; border-radius: 10px; width: 100%; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>

@auth
    @if(Auth::user()->role === 'user')
        <nav>
            <a href="#" class="logo">QC QConnect</a>
            <div class="user-menu">
                <span style="font-weight: 600;"><i class="fa-solid fa-circle-user"></i> {{ Auth::user()->fullname }}</span>
                <a href="/logout" style="margin-left:20px; color: #ef4444; text-decoration:none; font-weight: 600;">Déconnexion</a>
            </div>
        </nav>

        <div class="container">
            <div class="header-actions">
                <h1 style="font-size: 1.8rem; font-weight: 800;">Questions à proximité</h1>
                <button onclick="openModal()" class="btn-ask"><i class="fa-solid fa-plus"></i> Poser une question</button>
            </div>

            @if(isset($questions) && $questions->count() > 0)
                @foreach($questions as $question)
                    <div class="question-card">
                        <div class="question-header" style="display:flex; align-items:center; gap:12px; margin-bottom:1rem;">
                            <div class="avatar"><i class="fa-solid fa-user"></i></div>
                            <div class="user-info">
                               @if($question->user_id === Auth::user()->id)
                                    <h4>{{ Auth::user()->fullname ?? 'Anonyme' }}</h4>
                                    <span style="font-size: 0.85rem; color:var(--text-muted);">Publié {{ $question->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="question-content">
                            <div class="location-tag"><i class="fa-solid fa-location-dot"></i> {{ $question->city }}</div>
                            <h2 style="font-size: 1.3rem; margin:10px 0;">{{ $question->titre }}</h2>
                            <p style="color:var(--text-muted); line-height:1.5;">{{ $question->description }}</p>
                        </div>

                        <div class="replies-section">
                            <h5 style="margin-bottom: 10px; font-size: 0.9rem;"><i class="fa-regular fa-comments"></i> Réponses :</h5>

                            {{-- Hna kaddire l-boucle dial les réponses li m3elqin b had l-question --}}
                            @if(isset($question->replies) && $question->replies->count() > 0)
                                @foreach($question->replies as $reply)
                                    <div class="reply-item">
                                        <div class="reply-user">{{ $reply->user->fullname }}</div>
                                        <div class="reply-text">{{ $reply->message }}</div>
                                    </div>
                                @endforeach
                            @else
                                <p style="font-size: 0.8rem; color: var(--text-muted);">Aucune réponse pour le moment.</p>
                            @endif

                            <form action="{{ route('replies.store', $question->id) }}" method="POST" class="reply-form">
                                @csrf
                                <input type="text" name="message" class="reply-input" placeholder="Écrire une réponse..." required>
                                <button type="submit" class="btn-reply">Répondre</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem; background: white; border-radius: 16px; border: 2px dashed #e2e8f0;">
                    <p style="color: var(--text-muted); font-weight: 500;">Aucune question trouvée.</p>
                </div>
            @endif
        </div>

        <div id="postModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2 style="margin-bottom: 1.5rem; font-weight: 800;">Poser une question</h2>
                <form action="{{ route('questions') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="titre" placeholder="Ex: Panne d'électricité" required>
                    </div>
                    <div class="form-group">
                        <label>Localisation</label>
                        <input type="text" name="city" placeholder="Votre ville" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" placeholder="Détails..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Publier</button>
                </form>
            </div>
        </div>
    @endif
@endauth

<script>
    function openModal() { document.getElementById('postModal').style.display = 'block'; }
    function closeModal() { document.getElementById('postModal').style.display = 'none'; }
</script>
</body>
</html>
