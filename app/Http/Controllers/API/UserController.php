<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Utilisateurs récupérés avec succès',
            'users' => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, User $user)
    {

        // ********* Syntaxe 1 *********
        $user = User::create([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $user->update([
                'image' => $imageName
            ]);
        }

        // // ********* Syntaxe 2 *********
        // $user = new User();
        // $user->pseudo = $request->pseudo;
        // $user->image = $request->image;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        // $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé avec succès !',
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::with('posts', 'comments', 'role')->get();

        // On retourne les résultats en JSON
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur récupéré avec succès !',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $user->update([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
        ]);

        // si nouveau mdp choisi (et qui respecte bien sûr les critères de sécurité du validateur)
        if ($request->password) {

            // si ancien mdp fourni ET valide (vérifié via Hash::check), modification validée 
            if ($request->oldPassword && Hash::check($request->oldPassword, User::find($user->id)->password)) {
                // on sauvegarde le nouveau mot de passe hashé
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                // sinon => on renvoie une erreur
            } else {
                return response()->json(['mot de passe actuel non renseigné ou incorrect'], 400);
            }
        }

        // sauvegarde de la nouvelle image (si envoyée)
        if ($request->image) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $user->update([
                'image' => $imageName
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur modifié avec succès !',
            'user' => $user,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Auth::guard('web')->logout();
        return response()->json([
            'status' => true,
            'message' => 'Utilisateur supprimé avec succès !',
            'user' => $user,
        ]);
    }
}
