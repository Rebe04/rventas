@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Ej: Juan Suarez">
            @error('name')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy='phone' class="form-control" placeholder="Ej: 311 123 4567"
                maxlength="10">
            @error('phone')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy='email' class="form-control" placeholder="Ej: juansuarez@example.com">
            @error('email')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" wire:model.lazy='password' class="form-control" placeholder="••••••••••">
            @error('password')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select class="form-control" wire:model.lazing="status">
                <option value="Elegir" selected>Elegir</option>
                <option value="Active" selected>Activo</option>
                <option value="Locked" selected>Bloqueado</option>
            </select>
            @error('status')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Asignar role</label>
            <select class="form-control" wire:model.lazing="profile">
                <option value="Elegir" selected>Elegir</option>
                @foreach ($roles as $role)
                <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
            @error('profile')
            <span class="text-danger er">{{$message}}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
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