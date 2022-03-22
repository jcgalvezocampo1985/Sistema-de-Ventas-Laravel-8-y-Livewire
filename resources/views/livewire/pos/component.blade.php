@can('sales_index')
<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">
            <!-- Detalles -->
            @include("livewire.pos.partials.detail")
        </div>
        <div class="col-sm-12 col-md-4">
            <!-- Total -->
            @include("livewire.pos.partials.total")
            @include("livewire.pos.partials.denominations")
        </div>
    </div>
</div>
@else
<h2>{{ abort(403) }}</h2>
@endcan
<script src="{{ asset('plugins/dmauro-Keypress-70a58fb/keypress-2.1.5.min.js') }}"></script>
<script src="{{ asset('plugins/onscan/onscan.min.js') }}"></script>

@include("livewire.pos.scripts.scan")
@include("livewire.pos.scripts.general")
@include("livewire.pos.scripts.shortcuts")
@include("livewire.pos.scripts.events")

