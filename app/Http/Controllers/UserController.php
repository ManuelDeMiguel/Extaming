<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FriendshipRequest;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $user->load('receivedFriendRequests');
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado exitosamente.');
    }

    public function otherProfile(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('profile');
        }

        return view('users.other_profile', compact('user'));
    }

    public function sendFriendRequest(User $user)
    {
        $existingRequest = FriendshipRequest::where([
            'sender_id' => $user->id,
            'receiver_id' => auth()->user()->id,
        ])->first();

        if ($existingRequest) {
            // Si ya existe una solicitud entrante, aceptarla automáticamente
            $this->acceptFriendRequest($user);
        } else {
            // Si no existe, crear una nueva solicitud
            $request = new FriendshipRequest([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $user->id,
            ]);
            $request->save();
        }

        return back()->with('success', 'Solicitud de amistad enviada.');
    }

    public function cancelFriendRequest(User $user)
    {
        auth()->user()->sentFriendRequests()->where('receiver_id', $user->id)->delete();
        return back()->with('success', 'Solicitud de amistad cancelada.');
    }

    public function acceptFriendRequest(User $user)
    {
        $authUser = auth()->user();

        $request=FriendshipRequest::where([
            'sender_id' => $user->id,
            'receiver_id' => $authUser->id,
        ])->first();

        if($request !== null){
            $authUser->friends()->attach($user->id);
            $user->friends()->attach($authUser->id);

            $request->delete();

            return back()->with('success', 'Solicitud de amistad aceptada.');
        }

        return back()->with('error', 'No se pudo aceptar la solicitud de amistad.');
    }

    public function rejectFriendRequest(User $user)
    {
        $authUser = auth()->user();

        FriendshipRequest::where([
            'sender_id' => $user->id,
            'receiver_id' => $authUser->id,
        ])->delete();
        return back()->with('success', 'Solicitud de amistad rechazada.');
    }

    public function removeFriend(User $user)
    {
        $authUser = auth()->user();

        $authUser->friends()->detach($user->id);
        $user->friends()->detach($authUser->id);

        return back()->with('success', 'Amistad eliminada.');
    }
}


