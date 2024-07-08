<?php

namespace App\Http\Controllers;

use App\Models\Exel;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Note;
use App\Models\Next_move;
use App\Models\Interaction;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Volunteer_act_campaign;
use App\Models\Volunteer_does_donation;
use App\Models\Volunteer_pledges_donation;
use App\Models\Volunteer_scale;
use App\Models\Volunteer_sign_call;
use App\Models\Volunteer_use_canal;
use App\Models\Volunteer_use_group;
use App\Models\Next_move_type;
use App\Models\Interaction_type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InteractionController extends Controller
{
    //
    public function create(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'interaction_type' => 'required',
            'volunteer_id' => 'required',
            'interactor_id' => 'required',
            'next_move_type' => 'nullable',
            'next_move' => 'nullable',
            'interaction' => 'nullable',
            'next_date' => 'nullable',
            'interaction' => 'nullable',
            'donation_pledge' => 'nullable',
            'desincription' => 'nullable',
            'whatsapp' => 'nullable'
        ]);
        $formFields['created_at'] = date('Y-m-d H:i:s', strtotime('now'));
        //dd($formFields );
        $interaction = Interaction::insertGetId([
            "interactor_id" => $formFields['interactor_id'], "interaction_type" => $formFields['interaction_type'],
            "interaction" => $formFields['interaction'], "volunteer_id" => $formFields['volunteer_id'], "context_id" => 1, "created_at" => $formFields['created_at']
        ]);
        //dd($interaction);
        Next_move::create([
            "next_move_type" => $formFields['next_move_type'], "description" => $formFields['next_move'],
            "organizer_id" => $formFields['interactor_id'], "volunteer_id" => $formFields['volunteer_id'], "date" => $formFields['next_date']
        ]);
        Volunteer_pledges_donation::create([
            "donations_amount" => $formFields['donation_pledge'],
            "interaction_id" => $interaction, "volunteer_id" => $formFields['volunteer_id']
        ]);
        if (isset($formFields['desincription'])) {
            if (intval($formFields['desincription']) >= 1) {
                $phones = Phone::select('id', 'phone_number', 'opt_in')->where('volunteer_id', '=', $formFields['volunteer_id'])->get();
                foreach ($phones as $phone) {
                    $phone->opt_in = 0;
                    $phone->save();
                }
                if (intval($formFields['desincription']) >= 2) {
                    $emails = Email::select('id', 'email', 'opt_in')->where('volunteer_id', '=', $formFields['volunteer_id'])->get();
                    foreach ($emails as $email) {
                        $email->opt_in = 0;
                        $email->save();
                    }
                    if (intval($formFields['desincription']) == 3) {
                        Next_move::create([
                            "next_move_type" => 6, "description" => 'supprimer de la db',
                            "organizer_id" => 1, "volunteer_id" => $formFields['volunteer_id']
                        ]);
                    }
                }
            }
        }
        if (isset($formFields['whatsapp'])) {
            Next_move::create([
                "next_move_type" => 7, "description" => 'ajouter dans le groupe blablabla',
                "organizer_id" => 1, "volunteer_id" => $formFields['volunteer_id']
            ]);
        }

        return back();

        dd($formFields);
    }
}
