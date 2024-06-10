<?php
/**
 * @file users.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 14.11.2023
 */
?>

<div class="modal" id="Users">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un Utilisateur</h4>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="/usersadd">
                    @csrf <!-- juste de la securité  https://laravel.com/docs/5.8/csrf -->
                    <div class="mb-3 mt-3">
                        <label for="name">Nom de l'utilisateur</label>
                        <input type="text" class="form-control" name="name" placeholder="Username"
                               value="{{old('name')}}">
                        @error('name')
                        <p>{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="id"  hidden>id:</label>
                        <input type="number" class="form-control" name="id" placeholder="id"
                               value="{{$sets->id}}" hidden>
                        @error('id')
                        <p>{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mb-3 row">

                        <button type="submit" name="sign" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Ajouter</button>
                        <div class="col-2"></div>

                        <button type="reset" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Annuler</button>
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>

        </div>
    </div>
</div>
