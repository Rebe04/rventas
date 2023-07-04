</div>
<div class="modal-footer">
    <button wire:click.prevent="resetUI()" type="button" class="btn btn-light close-modal"
        data-dismiss="modal">CERRAR</button>
    @if ($selected_id < 1) <button wire:click.prevent="store()" type="button" class="btn btn-dark close-modal">
        GUARDAR</button>

        @else

        <button wire:click.prevent="update()" type="button" class="btn btn-dark close-modal">ACTUALIZAR</button>

        @endif
</div>
</div>
</div>
</div>