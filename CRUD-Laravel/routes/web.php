<?php

use App\Http\Controllers\EtudiantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//on déclare une route etudiant qui sera routourné par
//la fonction liste_etudiant de la classe EtudiantController

Route::get('/etudiants', [EtudiantController::class, 'liste_etudiant'] )
    ->name('app_etudiants'); //route etudiant

Route::get('/ajouter', [EtudiantController::class, 'ajouter_etudiant'] )
    ->name('app_ajouter_etudiant'); //route ajouter_etudiant qui redirige vers le lien d'ajout des etudians

Route::get('/update-etudiant/{id}', [EtudiantController::class, 'update_etudiant'] )
    ->name('app_update_etudiant'); //route qui permet de rediriger vers la route update

Route::get('/delete-etudiant/{id}', [EtudiantController::class, 'delete_etudiant'] )
    ->name('app_delete_etudiant'); //route qui permet de rediriger vers la route update

Route::post('/update/traitement', [EtudiantController::class, 'upadte_etudiant_traitement'] )
    ->name('app_update_etudiant_traitement'); //route qui permet de modifier les informations d'un etudiant

Route::post('/ajouter/traitement', [EtudiantController::class, 'ajouter_etudiant_traitement'] )
    ->name('app_ajouter_etudiant_traitement'); //route ajoute
