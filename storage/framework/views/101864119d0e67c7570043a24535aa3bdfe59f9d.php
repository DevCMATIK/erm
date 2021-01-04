<div class="modal-header">
    <h5 class="modal-title"><?php echo $__env->yieldContent('modal-title'); ?>

    </h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fal fa-times"></i></span>
    </button>
</div>
<div class="modal-body">
    <?php echo $__env->yieldContent('modal-content'); ?>
</div>
<div class="modal-footer">

    <?php if (! empty(trim($__env->yieldContent('no-submit')))): ?>
        <?php echo $__env->yieldContent('no-submit'); ?>
    <?php else: ?>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onClick="$('.modal-content form').submit();">Guardar</button>
    <?php endif; ?>
</div>

<?php echo $__env->yieldContent('modal-validation'); ?>
<script>

    $('.fire-modal').on('click',function(e){
        e.preventDefault();
        loadModal($(this).attr('href'))
    });
</script>
<?php /**PATH /shared/httpd/erm/resources/views/components/modals/form-modal.blade.php ENDPATH**/ ?>