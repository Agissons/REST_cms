<?php
/**
 * @file display.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 19.09.2023
 */
$title = "Gestion";

?>
@extends('layout')



@section('content')

    <div class="container ">
        <div class="p-3 " style=" border-style: outset; border-radius: 6px">
            <form method="POST" action="/newinteractions">
                @csrf <!-- juste de la securité  https://laravel.com/docs/5.8/csrf -->
                <div class="mb-3 mt-3" hidden>
                    <label for="volunteer_id">contenu de l'interaction</label>
                    <input type="number" class="form-control" name="volunteer_id" placeholder="contenu de l'interaction"
                       value="{{$volunteer->id}}">
                    @error('volunteer_id')
                    <p>{{$message}}</p>
                    @enderror
                </div><div class="mb-3 mt-3" hidden>
                    <label for="interactor_id">contenu de l'interaction</label>
                    <input type="number" class="form-control" name="interactor_id" placeholder="contenu de l'interaction"
                       value="{{auth()->user()->id}}">
                    @error('interactor_id')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="interaction_type" >type d'interaction</label>
                    <select type="text" class="form-control" name="interaction_type" >
                    @foreach($interaction_types as $interaction_type)
                    <option value="{{$interaction_type->id}}">{{$interaction_type->type}}</option>
                    @endforeach
                    @error('interaction_type')
                    <p>{{$message}}</p>
                    @enderror
                    </select>
                </div>
                <div class="mb-3 mt-3">
                    <label for="interaction">contenu de l'interaction</label>
                    <input type="text" class="form-control" name="interaction" placeholder="contenu de l'interaction"
                       value="{{old('interaction')}}">
                    @error('interaction')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <input type="checkbox"  name="whatsapp" >
                    <label for="whatsapp" >Veux être rajouter sur whatsapp</label>
                    @error('whatsapp')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <input type="radio" id="1" name="desincription" value='1'>
                    <label for="1">Ne veux plus être appeller</label><br>
                    <input type="radio" id="2" name="desincription" value='2'>
                    <label for="2">Ne veux plus être contacter</label><br>
                    <input type="radio" id="3" name="desincription" value='3'>
                    <label for="3">veux être suprimer de la base de donnée</label>
                    @error('desincription')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="raison">Raison de la desincription</label>
                    <input type="text" class="form-control" name="raison" placeholder="Raison de la desincription"
                       value="{{old('raison')}}">
                    @error('next_move')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="interessed">interessé par</label>
                </br>
                    <input type="checkbox"  name="whatsapp" >
                    <label for="whatsapp" >Phoning</label>
                    @error('whatsapp')
                    <p>{{$message}}</p>
                    @enderror
                </br>
                    <input type="checkbox"  name="whatsapp" >
                    <label for="whatsapp" >Terain</label>
                    @error('whatsapp')
                    <p>{{$message}}</p>
                    @enderror
                </br>
                    <input type="checkbox"  name="whatsapp" >
                    <label for="whatsapp" >Grève Féministe</label>
                    @error('whatsapp')
                    <p>{{$message}}</p>
                    @enderror
                </br>
                    <input type="checkbox"  name="whatsapp" >
                    <label for="whatsapp" >Festival de la cité</label>
                    @error('whatsapp')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="next_move_type" >type de la prochaine action</label>
                    <select type="text" class="form-control" name="next_move_type" >
                    @foreach($next_move_types as $next_move_type)
                    <option value="{{$next_move_type->id}}">{{$next_move_type->type}}</option>
                    @endforeach
                    @error('next_move_type')
                    <p>{{$message}}</p>
                    @enderror
                    </select>
                </div>
                <div class="mb-3 mt-3">
                    <label for="next_move">prochaine action:</label>
                    <input type="text" class="form-control" name="next_move" placeholder="Decrivez la prochaine action"
                       value="{{old('next_move')}}">
                    @error('next_move')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="next_date">date de la prochaine action:</label>
                    <input type="datetime-local" class="form-control" name="next_date" placeholder="date de la prochaine action"
                       value="{{old('next_date')}}">
                    @error('next_date')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="donation_pledge">promesse de don:</label>
                    <input type="number" class="form-control" name="donation_pledge" placeholder="Montant de la promesse de don"
                       value="{{old('donation_pledge')}}">
                    @error('donation_pledge')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <input type="checkbox"  name="donation" >
                    <label for="donation" >A fait un don pendant l'appel</label>
                    @error('donation')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="entousiasmed">entousiasmed ou pas</label>
                    <input type="text" class="form-control" name="entousiasmed" placeholder="Decrivez la prochaine action"
                       value="{{old('entousiasmed')}}">
                    @error('entousiasmed')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="engagement_spe">engagement speciale</label>
                    <input type="text" class="form-control" name="engagement_spe" placeholder="Decrivez la prochaine action"
                       value="{{old('engagement_spe')}}">
                    @error('engagement_spe')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="ressource">ressource +++</label>
                    <input type="text" class="form-control" name="ressource" placeholder="Decrivez la prochaine action"
                       value="{{old('ressource')}}">
                    @error('ressource')
                    <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3 row">

                    <button type="submit" name="sign" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Crée</button>
                    <div class="col-2">

                    </div>
                    <button type="reset" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Annuler</button>
                </div>

            </form>
        </div>
        <div class="p-3 " style=" border-style: outset; border-radius: 6px">
            <div class="row">
                <div class="col-4">
                    <h4>{{$volunteer->first_name}} {{$volunteer->last_name}}</h4>
                    </br>
                    <p>adresse:</p>
                    <p>{{$volunteer->primary_address1}}</p>
                    <p>{{$volunteer->primary_zip}} {{$volunteer->primary_city}} {{$volunteer->primary_state}}</p>
                    <p>echelle de l'engagement: {{$volunteer->scale}}</p>
                    <p>Organizer resposable: {{$volunteer->username}}</p>
                    
                </div>
                <div class="col-4">
                    @if($emails->isEmpty())
                    <div class="text-center m-3">
                        <p>il n'y aucune adresse mail enregistré</p>
                    </div>
                    @else
                    @foreach($emails as $email)
                    <div class="text-center m-3" @if($email->opt_in ==1)
                        style="background-color:green"
                        @else
                        style="background-color:red"
                        @endif>
                        <p>email: {{$email->email}}</p>
                    </div>
                    @endforeach
                    @endif
                    @if($phones->isEmpty())
                    <div class="text-center m-3">
                        <p>il n'y aucun numéro de téléphone </p>
                    </div>
                    @else
                    @foreach($phones as $phone)
                    <div class="text-center m-3" @if($phone->opt_in ==1)
                        style="background-color:green"
                        @else
                        style="background-color:red"
                        @endif>
                        <p>Numéro de télephone: {{$phone->phone_number}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="col-4">
                    @if($notes->isEmpty())
                    <div class="text-center m-3">
                        <p>il n'y aucun note associer à ce contact</p>
                    </div>
                    @else
                    @foreach($notes as $note)
                    <div class="text-center m-3" >
                        <p>Notes:</p>
                        <p>{{$note->content}}</p>
                    </div>
                    @endforeach
                    @endif
                    

            
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <h4>Liste des dons</h4>
                    @if($donations->isEmpty())
                    <div class="text-center m-3">
                        <p>il n'y aucune donation enregistré</p>
                    </div>
                    @else
                    @foreach($donations as $donation)
                    <div class="text-center m-3" >
                        <p>don efectué le: {{$donation->created_at}}</p>
                        <p>montant: {{$donation->donations_amount}} CHF</p>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <h4>liste des interactions</h4>
                    @if($interactions->isEmpty())
                    <div class="text-center m-3">
                        <p>Aucune interaction avec cette personne à été enregistré</p>
                    </div>
                    @else
                    @foreach($interactions as $interaction)
                    <div class="text-center m-3" >
                        <div class="row">
                            <div class="col-8">
                                <p>interaction efectuée le: {{$interaction->created_at}}</p>
                                <p>dans le cadre de la campagne: {{$interaction->name}}</p>
                            </div>
                            <div class="col-4">
                                <p>faites par: {{$interaction->username}}</p>
                                <p>type: {{$interaction->type}}</p>
                            </div>
                        </div>
                        <p>contenu :</p>
                        <p>{{$interaction->interaction}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <h4>liste des prochaines étapes</h4>
                    @if($next_moves->isEmpty())
                    <div class="text-center m-3">
                        <p>il n'y aucune prochaine étape specifique</p>
                    </div>
                    @else
                    @foreach($next_moves as $next_move)
                    <div class="text-center m-3" >
                        <div class="row">
                            <div class="col-8">
                                <p>prochaine étape de type: {{$next_move->type}}</p>
                            </div>
                            <div class="col-4">
                                <p>supervisé par: {{$next_move->username}}</p>
                                
                            </div>
                        </div>
                        <p>description :</p>
                        <p>{{$next_move->description}}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
                    
            </div>
            <div class="col-4">
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <h4>liste des canaux ou canals</h4>
                    @if($canals->isEmpty())
                    <div class="text-center m-3">
                        <p>ne fait partie d'aucun canaux</p>
                    </div>
                    @else
                    @foreach($canals as $canal)
                    <div class="text-center m-3" >
                        <p>Nom du canal: {{$canal->name}}</p>
                        <p>Moyen d'entrée: {{$canal->entry_way}}</p> 
                        @foreach($groups as $group)
                        <h4>liste des groupes</h4>
                        <div class="row">
                            <div class="col-4">
                                <p>Nom du groupe:</p>
                                <p>entrée le:</p>
                                @if($group->left !='0000-00-00 00:00:00')
                                <p>sortie le:</p>
                                @endif
                            </div>
                            <div class="col-8">
                                <p>{{$group->name}}</p>
                                <p>{{$group->created_at}}</p>
                                @if($group->left !='0000-00-00 00:00:00')
                                <p>{{$group->left}}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class=" col-4 ">
                <div class="p-3 " style=" border-style: outset; border-radius: 6px">
                    <h4>liste des particiaption au campagne</h4>
                    @if($campaigns->isEmpty())
                    <div class="text-center m-3">
                        <p>N'a participer à aucune campagne</p>
                    </div>
                    @else
                    @foreach($campaigns as $campaign)
                    <div class="text-center m-3" >
                        <p>Nom de la campagne: {{$campaign->name}}</p>
                        @if($campaign->info)
                        <p>Veux rester informer</p>
                        @endif
                        @if($campaign->soutien)
                        <p>Soutien la campagne</p>
                        @endif
                        @foreach($calls as $call)
                        <h4>liste des appels signé</h4>
                            <p>Nom du groupe: {{$call->name}}</p>
                            @if($call->question !='')
                            <p>reponse à la question</p>
                            <p>{{$call->question}}</p>
                            @endif
                        @endforeach
                        
                    </div>
                    @endforeach
                    @endif
                </div>

                </div>

            </div>

        </div>
        <div class=" col-4 ">
            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Users"> User Gestion</button>
            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Nourish"> Nourish</button>
            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#Session"> New Session</button>
        </div>
      




    </div>
    <!--    include('volunteers.modal.guanoadd')
    include('volunteers.modal.wormsadd')
    include('volunteers.modal.wormslist')
    include('volunteers.modal.users')
    include('volunteers.modal.nourish')
    include('volunteers.modal.session') -->

@endsection
