<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 wire:loading class="text-center text-warning"> Por favor espere</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">
                                    </span>
                                </span>
                            </div>
                            <input class="form-control" type="text" wire:model.lazy="roleName" placeholder="ej: Admin"
                                maxlength="255">
                        </div>
                        @error('roleName')
                        <span class="text-danger er">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click.prevent="resetUI()" type="button" class="btn btn-light close-modal"
                    data-dismiss="modal">CERRAR</button>
                @if ($selected_id < 1) <button wire:click.prevent="createRole()" type="button"
                    class="btn btn-dark close-modal">
                    GUARDAR</button>

                    @else

                    <button wire:click.prevent="updateRole()" type="button"
                        class="btn btn-dark close-modal">ACTUALIZAR</button>

                    @endif
            </div>
        </div>
    </div>
</div>