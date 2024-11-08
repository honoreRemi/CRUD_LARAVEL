<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD IN LARAVEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>


    <div class="container">
        <div class="row">
            <div class="col s12">
                <h1>AJOUTER UN ETUDAINT</h1>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ (session('status')) }}
                    </div>
                @endif

                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger">{{ $error}}</li>
                    @endforeach
                </ul>


                <form class="from-group" method="POST" action="/ajouter/traitement">
                    @csrf

                    <div class="row g-3 align-items-center">
                        <div class="mb-3">
                            <label for="Nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" id="nom">
                        </div>
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prenom</label>
                            <input type="text" name="prenom" class="form-control" id="prenom">
                        </div>
                        <div class="mb-3">
                            <label for="Classe" class="form-label">Classe</label>
                            <input type="text" name="classe" class="form-control" id="classe">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                        <a href="etudiants" class="btn btn-danger">Students list</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
