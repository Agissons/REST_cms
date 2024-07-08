<?php
/**
 * @file wormsadd.blade.php
 * @brief file description
 * @author Created by Blooooo
 * @version 14.11.2023
 */
?>

<div class="modal" id="Wormsadd">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Nouvelle Récolte</h4>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="/wormsadd">
                    @csrf <!-- juste de la securité  https://laravel.com/docs/5.8/csrf -->
                    <div class="mb-3 mt-3">
                        <label for="worms">Quantité de Vers récoltée:</label>
                        <input type="number" class="form-control" name="worms" placeholder="Quantité de Vers (en g)"
                            value="{{ old('worms') }}">
                        @error('worms')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="id" hidden>id:</label>
                        <input type="number" class="form-control" name="id" placeholder="id"
                            value="{{ $sets->id }}" hidden>
                        @error('id')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="code">Code:</label>
                        <input type="text" class="form-control" name="code" placeholder="Code"
                            value="{{ old('code') }}">
                        @error('code')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="weight">Poids:</label>
                        <input type="number" class="form-control" name="weight" placeholder="Poids"
                            value="{{ old('weight') }}">
                        @error('weight')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="boxe">Boite d'origine:</label>
                        <select type="number" class="form-control" name="boxe">
                            @foreach ($boxes as $boxe)
                                @if ($boxe->type == 'size4')
                                    <option value="{{ $boxe->type }}">{{ $boxe->name }}</option>
                                @endif
                            @endforeach
                            @error('weight')
                                <p>{{ $message }}</p>
                            @enderror
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <button type="submit" name="sign" class="btn btn-primary col-5"
                            style="background-color: #a7c957;color:#bc4749;border:#386641">Ajouter</button>
                        <div class="col-2"></div>
                        <button type="reset" class="btn btn-primary col-5"
                            style="background-color: #a7c957;color:#bc4749;border:#386641">Annuler</button>
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
