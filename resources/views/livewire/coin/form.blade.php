@include('common.modalHead')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model="type" class="form-control">
                <option disabled value="Elegir">Elegir</option>
                <option value="BILLETE">Billete</option>
                <option value="MONEDA">Moneda</option>
                <option value="OTRO">Otro</option>
            </select>
            @error('type')
            <span class="text-danger er">
                {{$message}}
            </span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <label>Valor</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-edit text-dark">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </span>
                </span>
            </div>
            <input class="form-control" type="number" wire:model.lazy="value" placeholder="ej: 0.00" maxlength="25">
        </div>
        @error('value')
        <span class="text-danger er">
            {{$message}}
        </span>
        @enderror
    </div>
    <div class="col-sm-12">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input form-control" wire:model="image"
                accept="image/x-png, image/gif, image/jpeg, image/jpg">
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image')
            <span class="text-danger er">
                {{$message}}
            </span>
            @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')