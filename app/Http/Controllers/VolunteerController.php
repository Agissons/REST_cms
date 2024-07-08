<?php

namespace App\Http\Controllers;

use App\Models\Exel;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Note;
use App\Models\Next_move;
use App\Models\Interaction;
use App\Models\Volunteer;
use App\Models\Volunteer_act_campaign;
use App\Models\Volunteer_does_donation;
use App\Models\Volunteer_pledges_donation;
use App\Models\Volunteer_sign_call;
use App\Models\Volunteer_use_canal;
use App\Models\Volunteer_use_group;
use App\Models\Next_move_type;
use App\Models\Interaction_type;

class VolunteerController extends Controller
{
    //
    public function full($id)
    {
        $next_move_types = Next_move_type::select('id', 'type')
            ->get();

        $interaction_types = Interaction_type::select('id', 'type')
            ->get();


        $volunteer = Volunteer::select('volunteers.id', 'volunteers.first_name', 'volunteers.last_name', 'volunteers.primary_address1', 'volunteers.primary_state', 'volunteers.primary_city', 'volunteers.primary_zip', 'volunteer_scales.scale', 'users.username')->where('volunteers.id', $id)
            ->join('volunteer_scales', 'volunteer_scales.id', "=", 'volunteers.volunteer_scale')
            ->join('users', 'users.id', "=", 'volunteers.organizer_id')
            ->get();

        $emails = Email::select('email', 'opt_in')->where('volunteer_id', '=', $id)->get();

        $phones = Phone::select('phone_number', 'opt_in')->where('volunteer_id', '=', $id)->get();

        $notes = Note::select('content')->where('volunteer_id', '=', $id)->get();

        $next_moves = Next_move::select('next_moves.description', 'next_move_types.type', 'users.username')->where('volunteer_id', '=', $id)
            ->leftjoin('users', 'users.id', "=", 'next_moves.organizer_id')
            ->join('next_move_types', 'next_move_types.id', "=", 'next_moves.next_move_type')->get();
        //dd($next_moves);

        $interactions = Interaction::select('interactions.interaction', 'users.username', 'interactions.created_at', 'interaction_types.type', 'campaigns.name')->where('volunteer_id', '=', $id)
            ->join('users', 'users.id', "=", 'interactions.interactor_id')
            ->join('campaigns', 'campaigns.id', "=", 'interactions.context_id')
            ->join('interaction_types', 'interaction_types.id', "=", 'interactions.interaction_type')->get();

        $campaigns = Volunteer_act_campaign::select('volunteer_act_campaigns.soutien', 'volunteer_act_campaigns.info', 'campaigns.name')->where('volunteer_id', '=', $id)
            ->join('campaigns', 'campaigns.id', "=", 'volunteer_act_campaigns.campaign_id')->get();

        $donations = Volunteer_does_donation::select('donations_amount', 'created_at')->where('volunteer_id', '=', $id)
            ->get();
        $donation_pledges = Volunteer_pledges_donation::select('donations_amount', 'created_at')->where('volunteer_id', '=', $id)
            ->get();

        $calls = Volunteer_sign_call::select('volunteer_sign_calls.question', 'calls.name')->where('volunteer_id', '=', $id)
            ->join('calls', 'calls.id', "=", 'volunteer_sign_calls.call_id')->get();

        $canals = Volunteer_use_canal::select('canals.name', 'volunteer_use_canals.entry_way')->where('volunteer_id', '=', $id)
            ->join('canals', 'canals.id', "=", 'volunteer_use_canals.canal_id')->get();

        $groups = Volunteer_use_group::select('volunteer_use_groups.left', 'volunteer_use_groups.created_at', 'canal_groups.name')->where('volunteer_id', '=', $id)
            ->join('canal_groups', 'canal_groups.id', "=", 'volunteer_use_groups.groups_id')->get();


        //dd( $calls, $campaigns, $canals, $groups);
        return view('interactions.display', [
            'volunteer' => $volunteer[0],
            'emails' => $emails, 'phones' => $phones, 'notes' => $notes, 'next_moves' => $next_moves, 'interactions' => $interactions,
            'campaigns' => $campaigns, 'donations' => $donations, 'calls' => $calls, 'canals' => $canals, 'groups' => $groups, 'interaction_types' => $interaction_types, 'next_move_types' => $next_move_types
        ]);
    }

    public function display()
    {


        $volunteers = Volunteer::select('volunteers.id', 'volunteers.first_name', 'volunteers.last_name', 'volunteers.primary_zip', 'volunteer_scales.scale', 'users.username')
            ->join('volunteer_scales', 'volunteer_scales.id', "=", 'volunteers.volunteer_scale')
            ->join('users', 'users.id', "=", 'volunteers.organizer_id')
            ->get();

        return view('volunteers.gestion', ['volunteers' => $volunteers]);
    }

    public function create()
    {

        $user = Exel::where('id', '=', 12)->get();
        dd($user[0]);

        $Volunteer = Volunteer::create([
            "first_name" => $user[0]->first_name, "last_name" => $user[0]->last_name,
            "primary_zip" => $user[0]->primary_zip, "primary_address1" => 'chemin du bois de la fontaine 6', "primary_state" => 'VD',
            "primary_city" => 'Lausanne', "primary_country" => 'Suisse', "primary_country_code" => 'CH',
            "organizer_id" => 1, "volunteer_scale" => 1
        ]);
        //dd($Volunteer);
        Volunteer_does_donation::create([
            "volunteer_id" => $Volunteer->id, "campaign_id" => 1,
            "donations_amount" => $user[0]->donations_amount
        ]);
        Volunteer_act_campaign::create([
            "volunteer_id" => $Volunteer->id, "campaign_id" => 1,
            "info" => 1, "soutien" => 0
        ]);
        Volunteer_sign_call::create([
            "volunteer_id" => $Volunteer->id, "call_id" => 1,
            "question" => 'la vie la mort Zihuatanejo'
        ]);
        Volunteer_use_canal::create([
            "volunteer_id" => $Volunteer->id, "canal_id" => 1,
            "entry_way" => $user[0]->wa_enter_way
        ]);
        Volunteer_use_group::create(["volunteer_id" => $Volunteer->id, "groups_id" => 1]);
        Email::insert([
            "volunteer_id" => $Volunteer->id, "opt_in" => 1,
            "email" => $user[0]->email
        ]);
        Phone::insert([
            "volunteer_id" => $Volunteer->id, "opt_in" => 1,
            "phone_number" => $user[0]->phone_number
        ]);
        Note::create(["volunteer_id" => $Volunteer->id, "content" => "est le meilleur franchement je suis lui donnais le prix du meilleurs militant"]);
        Note::create(["volunteer_id" => $Volunteer->id, "content" => "pas facile à mobiliser mais bon il n'y a que lui qui sache coder alors on fait avec"]);

        $user2 = Exel::where('id', '=', 672)->get();
        //dd($user2[0]);

        $Volunteer2 = Volunteer::create([
            "first_name" => $user2[0]->first_name, "last_name" => $user2[0]->last_name,
            "primary_zip" => $user2[0]->primary_zip, "primary_address1" => 'Perdu quelquepart dans la montagne', "primary_state" => 'VS',
            "primary_city" => 'Collombey', "primary_country" => 'Suisse', "primary_country_code" => 'CH',
            "organizer_id" => 1, "volunteer_scale" => 1
        ]);
        //dd($Volunteer);
        Volunteer_does_donation::create([
            "volunteer_id" => $Volunteer2->id, "campaign_id" => 1,
            "donations_amount" => $user2[0]->donations_amount / 2
        ]);
        Volunteer_does_donation::create([
            "volunteer_id" => $Volunteer2->id, "campaign_id" => 1,
            "donations_amount" => $user2[0]->donations_amount / 2
        ]);
        Volunteer_act_campaign::create([
            "volunteer_id" => $Volunteer2->id, "campaign_id" => 1,
            "info" => 1, "soutien" => 1
        ]);
        Volunteer_sign_call::create([
            "volunteer_id" => $Volunteer2->id, "call_id" => 1,
            "question" => 'es-ce qu\'être gaucher, fait de moi quelqu\'un de gauche'
        ]);
        Volunteer_use_canal::create([
            "volunteer_id" => $Volunteer2->id, "canal_id" => 1,
            "entry_way" => $user2[0]->wa_enter_way
        ]);
        Volunteer_use_group::create(["volunteer_id" => $Volunteer2->id, "groups_id" => 1]);
        Email::insert([
            "volunteer_id" => $Volunteer2->id, "opt_in" => 0,
            "email" => $user2[0]->email
        ]);
        Email::insert([
            "volunteer_id" => $Volunteer2->id, "opt_in" => 1,
            "email" => 'Copertino@legoat.com'
        ]);
        Phone::insert([
            "volunteer_id" => $Volunteer2->id, "opt_in" => 0,
            "phone_number" => $user2[0]->phone_number
        ]);
        Note::create(["volunteer_id" => $Volunteer2->id, "content" => "aime la nature, l'astronomie et les animaux(non, pinnochio) est beaucoup avenant pour être honnete"]);
        // dd($user2[0]);
    }
}
