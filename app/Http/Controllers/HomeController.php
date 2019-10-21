<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Speler;
use App\Club;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clubs = Club::all();
        return view('home', ['Clubs' => $clubs]);
    }

    public function clubinfo($Clubnaam, $Filter = null)
    {
        $clubsinfo = Club::where('naam', $Clubnaam)->first();
        switch ($Filter){
            case "Voorhoede":
                $spelers = Speler::all()->where('positie', "Voorhoede")->where('club_naam', $Clubnaam);
                break;
            case "Middenveld":
                $spelers = Speler::all()->where('positie', "Middenveld")->where('club_naam', $Clubnaam);
                break;
            case "Achterhoede":
                $spelers = Speler::all()->where('positie', "Achterhoede")->where('club_naam', $Clubnaam);
                break;
            case "Doelman":
                $spelers = Speler::all()->where('positie', "Doelman")->where('club_naam', $Clubnaam);
                break;
            case "Topscoorders":
                $spelers = Speler::orderBy('doelpunten', 'DESC')->take(3)->where('club_naam', $Clubnaam)->get();
                break;
            case "Veteranen":
                $spelers = Speler::onlyTrashed()->where('club_naam', $Clubnaam)->get();
                break;
            default:
                $spelers = Speler::all()->where('club_naam', $Clubnaam);
        }
        return view('clubinfo', ['ClubsInfo' => $clubsinfo, 'Spelers' => $spelers]);
    }

    public function spelerToevoegen(Request $request)
    {
        $imageName = time().'.'.$request->file('afbeelding')->getClientOriginalExtension();
        $request->file('afbeelding')->move(public_path('images'), $imageName);

        $speler = new Speler();
        $speler->club_naam = $request->input('club');
        $speler->doelpunten = $request->input('doelpunten');
        $speler->positie = $request->input('positie');
        $speler->speler_naam = $request->input('speler_naam');
        $speler->afbeelding = $imageName;
        $speler->save();

        $clubsinfo = Club::where('naam', $request->input('club'))->first();
        return redirect()->route('clubinfo', $clubsinfo->naam);
    }

    public function SpelerVerwijderen($id)
    {
        $speler = Speler::find($id);
        $speler->delete();
        return redirect()->route('clubinfo', $speler->club_naam);
    }

    public function SpelerWijzigen(Request $request, $id)
    {
        //$imageName = time().'.'.$request->file('afbeelding')->getClientOriginalExtension();
        //$request->file('afbeelding')->move(public_path('images'), $imageName);

        $speler = Speler::find($id);
//        $speler->afbeelding = $imageName;
//        $speler->doelpunten = $request->input('doelpunten');
//        $speler->speler_naam = $request->input('spelerNaam');
//        $speler->save();
        return redirect()->route('clubinfo', $speler->club_naam);
    }
}
