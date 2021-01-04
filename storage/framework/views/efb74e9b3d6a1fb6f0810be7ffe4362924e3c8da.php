<h5><i class="fas fa-arrows-alt"></i> Dispositivos Disponibles</h5>
<div class="row mb-5">
    <div class="col-xl-12">
        <?php echo $__env->make('water-management.admin.panel.partials.available-devices', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<h5><i class="fas fa-cog"></i> Configurar Columnas</h5>
<div class="row mt-2">
    <?php for($i = 1; $i <= $subZone->configuration->columns; $i++): ?>
        <div class="col-sm-12 col-md-12 col-xl-<?php echo e((12 / (int)$subZone->configuration->columns)); ?> p-3" id="column_<?php echo e($subZone->id); ?>_<?php echo e($i); ?>">
            <div class="border p-2 rounded-plus pb-6">
                <?php if($subZone->configuration->block_columns == 1): ?>
                    <?php echo $__env->make('water-management.admin.panel.partials.column', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <ul class="draginto border p-2" id="drag_<?php echo e($subZone->id); ?>_<?php echo e($i); ?>">
                    <?php echo $__env->make('water-management.admin.panel.partials.sub-elements', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </ul>
            </div>
        </div>
    <?php endfor; ?>
</div>
<script>
    $('.column_name').blur(function(){
        let column = $(this).prop('id');
        let name = $(this).val();
        $.ajax({
            url : '/panel-columns/changeName',
            data : {
                name : name,
                column : column
            },
            success : function () {
                toastr.success('Nombre Modificado Correctamente');
            }
        });
    });

    $(function () {
        $(".draginto").sortable({
            connectWith: "ul",
            update: function(event, ui,parent) {
                var items = $(this).sortable('toArray').toString();
                console.log(items);
                console.log($(this).attr('id'));
                $.ajax({
                    url : '/panel-columns/updateItems',
                    data : {
                        items : items,
                        group : $(this).attr('id')
                    },
                    success : function()
                    {
                        location.reload();
                    }
                });
            }
        }).droppable();
        $("ul[id^='device']").draggable({
            connectToSortable: ".draginto",
        });
    });
</script>
<?php /**PATH /shared/httpd/erm/resources/views/water-management/admin/panel/partials/columns.blade.php ENDPATH**/ ?>