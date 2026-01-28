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

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        nav {
            background: white;
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo { font-weight: 800; font-size: 1.5rem; color: var(--primary); }

        /* Container principal */
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Header de la page */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .btn-ask {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-ask:hover { background: var(--primary-dark); }

        /* MODAL CSS - Zdt hadchi darouri bach l-modal t-ban s7i7 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            right: 20px; top: 10px;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-muted);
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box;
        }
        .btn-submit {
            background: var(--primary); color: white; border: none; padding: 12px;
            border-radius: 8px; width: 100%; font-weight: 600; cursor: pointer;
        }

        /* Question Card */
        .question-card {
            background: var(--card);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .question-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

        .user-info h4 { margin: 0; font-size: 1rem; }
        .user-info span { font-size: 0.8rem; color: var(--text-muted); }

        .question-content h2 {
            margin: 0.5rem 0;
            font-size: 1.25rem;
            color: var(--primary);
        }

        .location-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eef2ff;
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .stats i { color: var(--primary); cursor: pointer; }
    </style>
</head>
<body>

@auth
    @if(Auth::user()->role === 'user')
        <nav>
            <div class="logo">QC QConnect</div>
            <div class="user-menu">
                <span><i class="fa-solid fa-user"></i> {{ Auth::user()->fullname }}</span>
                <a href="/logout" style="margin-left:15px; color:red; text-decoration:none;">Déconnexion</a>
            </div>
        </nav>

        <div class="container">
            <div class="header-actions">
                <h1>Questions à proximité</h1>
                {{-- Sallaht l-function call hna --}}
                <a onclick="openModal()" class="btn-ask"><i class="fa-solid fa-plus"></i> Poser une question</a>
            </div>

            {{-- Jerréb t-7eyed had les commentaires bach t-affichie l-data dyalk --}}
{{--            @if(isset($questions))--}}
{{--                @forelse($questions as $question)--}}
                    <div class="question-card">
                        <div class="question-header">
                            <div class="avatar"><i class="fa-solid fa-user"></i></div>
                            <div class="user-info">
{{--                                <h4>{{ $question->user->fullname ?? 'Utilisateur' }}</h4>--}}
{{--                                <span>Publié le {{ $question->created_at->format('d M, Y') }}</span>--}}
                            </div>
                        </div>

                        <div class="question-content">
{{--                            <div class="location-tag"><i class="fa-solid fa-location-dot"></i> {{ $question->localisation }}</div>--}}
{{--                            <h2>{{ $question->titre }}</h2>--}}
{{--                            <p>{{ Str::limit($question->contenu, 150) }}</p>--}}
                        </div>

                        <div class="stats">
                            <span><i class="fa-regular fa-comment"></i> {{ $question->responses_count ?? 0 }} réponses</span>
                            <span><i class="fa-regular fa-star"></i> Ajouter aux favoris</span>
                        </div>
                    </div>
{{--                @endforelse--}}
{{--            @endif--}}
        </div>

        {{-- L-Modal --}}
        <div id="postModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Poser une question</h2>
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label>Localisation</label>
                        <input type="text" name="localisation" required>
                    </div>
                    <div class="form-group">
                        <label>Détails</label>
                        <textarea name="contenu" rows="4" required></textarea>
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
    window.onclick = function(event) {
        if (event.target === document.getElementById('postModal')) closeModal();
    }
</script>
</body>
</html>
