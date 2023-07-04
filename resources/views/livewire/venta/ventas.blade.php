<div>
    <style></style>
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">
            {{-- Detalles --}}
            @include("livewire.venta.partials.detail")
        </div>
        <div class="col-sm-12 col-md-4">
            {{-- Total --}}
            @include("livewire.venta.partials.total")

            {{-- Denominaciones --}}
            @include("livewire.venta.partials.coins")
        </div>
    </div>
</div>



<script src="{{ asset('plugins/dmauro-Keypress-70a58fb/keypress-2.1.5.min.js')}}"></script>
<script src="{{ asset('plugins/onscan/onscan.min.js')}}"></script>
@include("livewire.venta.scripts.general")
@include("livewire.venta.scripts.shortcuts")
@include("livewire.venta.scripts.scan")
@include("livewire.venta.scripts.events")