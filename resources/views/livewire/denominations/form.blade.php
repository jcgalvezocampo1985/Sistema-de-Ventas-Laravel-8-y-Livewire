@include("common.modalHead")

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select wire:model="type" class="form-control">
                <option value="Elegir">Seleccionar</option>
                @foreach($denominations as $denomination)
                <option value="{{ $denomination }}">{{ $denomination }}</option>
                @endforeach
            </select>
            @error("type") <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Valor</label>
            <input type="text" wire:model.lazy="value" class="form-control" placeholder="ej: 50.00" />
            @error("value") <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 mt-3">
        <div class="form-group custom-file">
            <input type="file" class="custom-file-input" wire:model="image" accept="image/x-png, image/x-gif, image/x-jpg" />
            <label class="custom-file-label">Imagen {{ $image }}</label>
            @error("image") <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include("common.modalFooter")
