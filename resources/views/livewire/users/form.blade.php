@include('common.modalHead')

<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Juan Pérez" />
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 9361199500" maxlength="10" />
            @error('phone') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email" wire:model.lazy="email" class="form-control" placeholder="ej: email@servidor.com"/>
            @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Password</label>
            <input type="password" wire:model.lazy="password" class="form-control" />
            @error('password') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Estatus</label>
            <select wire:model="status" class="form-control">
                <option value="">Seleccionar</option>
                <option value="Active">Activo</option>
                <option value="Locked">Bloqueado</option>
            </select>
            @error('status') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Rol</label>
            <select wire:model.lazy='roleid' class="form-control">
                <option value="">Seleccionar</option>
                @foreach($roles as $role):
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('roleid') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <label class="custom-file-label">Imagen de perfil</label>
            <input type="file" class="custom-file-input" wire:model="image" accept="image/x-png, image/x-gif, image/x-jpg;" />
            @error('image') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
