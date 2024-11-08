<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use PhpParser\Node\Expr\New_;

class EtudiantController extends Controller
{
    public function liste_etudiant(){
        //$etudiants = Etudiant::all(); // on crée un objet de type Etudiant et on recupère tous les champs de la tables etudiant avec la fonction all()
        $etudiants = Etudiant::paginate(1); // on crée un objet de type Etudiant et on recupère tous les champs de la tables etudiant avec la fonction all()
        //on peut passer rn mode pagination en utilisant : $etudiants = Etudiant::generate(10)
        return View('etudiants.liste', compact('etudiants'));
    }

    public function ajouter_etudiant(){
        return View('etudiants.ajouter');
    }

    public function ajouter_etudiant_traitement(Request $request){

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'classe' => 'required',

        ]);

        $etudiant = New Etudiant();
        $etudiant->nom = $request->nom;
        $etudiant->prenom = $request->prenom;
        $etudiant->classe = $request->classe;
        $etudiant->save(); //on utilisa la fonction save pour stocker les informations des etudiants

        return redirect('/ajouter')->with('status', 'L\'étudiant a bien été ajouter avec succes.');
    }

    //cette fonction recupère l'id de la table etudiant voila pourquoi elle prend en paramettre son id
    public function update_etudiant($id){
        //on recherche tout d'abord l'objet etudiant
        $etudiant = Etudiant::find($id);

        return view('etudiants.update', compact('etudiant'));//compact('etudiants') permet d'afficher les informations de la bd

    }

    public function upadte_etudiant_traitement(Request $request){

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'classe' => 'required',

        ]);

        //ici on recherche tout d'abord avec find($request->id) l'id de l'etudiant pour enfin modifier
        $etudiant = Etudiant::find($request->id);
        $etudiant->nom = $request->nom;
        $etudiant->prenom = $request->prenom;
        $etudiant->classe = $request->classe;
        $etudiant->update(); //on utilise la fonction update pour mettre à jour la table etudiant
        return redirect('/etudiants')->with('status', ' la modification de l\'étudiant a bien été effectué avec succes.');
    }

    public function delete_etudiant($id){

          //on recherche tout d'abord l'objet etudiant
          $etudiant = Etudiant::find($id);
          $etudiant->delete();
          return redirect('/etudiants')->with('status', ' la la suppression de l\'étudiant a bien été effectué avec succes.');


    }
}
