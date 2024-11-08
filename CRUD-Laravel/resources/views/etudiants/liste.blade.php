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


    <div class="container text-center">
        <div class="row">
            <div class="col s12">
                <h1>CRUD IN LARAVEL</h1>
                <hr>
                    <a href="ajouter" class="btn btn-primary">Add students</a>
                <hr>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ (session('status')) }}
                    </div>
                 @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>prenom</th>
                            <th>Classe</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ide = 1;
                        @endphp
                        @foreach($etudiants as $etudiant)
                        <tr>
                            {{-- on affiche les inofrmations de la table etudiant --}}
                            <td>{{$ide}}</td>
                            <td>{{$etudiant->nom}}</td>
                            <td>{{$etudiant->prenom}}</td>
                            <td>{{$etudiant->classe}}</td>
                            <td>
                                {{-- pour upate, on indique tout d'abord la route ensuite on referenti avec l'id --}}
                                <a href="/update-etudiant/{{$etudiant->id}}" class="btn btn-info">Update</a>
                                <a href="/delete-etudiant/{{$etudiant->id}}" class="btn btn-danger">Delete</a>
                            </td>

                        </tr>
                        @php
                            $ide += 1;
                        @endphp
                        @endforeach
                    </tbody>

                </table>
                {{-- on defini le {{$etudiants->links()}}  lorsqu'on utilise la fonction paginate() qui serait indiquer dans le controlleur EtudiantController --}}
                {{$etudiants->links()}} 
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
