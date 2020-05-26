<div class="modal-header">
    <h5 class="modal-title">@yield('modal-title')

    </h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fal fa-times"></i></span>
    </button>
</div>
<div class="modal-body">
    @yield('modal-content')
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    @hasSection('no-submit')
        @yield('no-submit')
    @else
        <button type="button" class="btn btn-primary" onClick="$('.modal-content form').submit();">Guardar</button>
    @endif
</div>

@yield('modal-validation')
<script>

    $('.fire-modal').on('click',function(e){
        e.preventDefault();
        loadModal($(this).attr('href'))
    });
</script>
