@include('common.modalHead')
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Rol</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Admin" maxlength="255" />
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
@include('common.modalFooter')
