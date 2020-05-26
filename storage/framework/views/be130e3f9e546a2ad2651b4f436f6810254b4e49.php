<?php if(isset($subZone->elements) && count ($subZone->elements) > 0): ?>
    <?php $__empty_1 = true; $__currentLoopData = $subZone->elements()->where('column',$i)->first()->sub_elements()->get()->groupBy(function($q){
        return $q->check_point_id;
    }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <ul id="device_<?php echo e($sub_element->first()->check_point_id); ?>" class="list-group">
            <li class="list-group-item cursor-move" style="width: 100%">
                <?php echo e($sub_element->first()->check_point->name); ?>

                <a href="javascript:void(0);" onclick="removeSubElement(<?php echo e($sub_element->first()->id); ?>)" class="float-right text-danger"><i class="fas fa-times fa-1x"></i></a>
                <a href="/subElementConfig/<?php echo e($sub_element->first()->id); ?>" <?php echo makeLinkRemote(); ?> class="float-right mx-2"><i class="fas fa-pen fa-1x"></i></a>
            </li>
        </ul>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
<?php endif; ?>

<script>
    function removeSubElement(sub_element)
    {
        Swal.fire({
            title: "Eliminar Punto de Control",
            text: "Si lo elimina perdera toda la configuracion para de este para la sub zona",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar"
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "GET",
                    url: '/removeSubElement/'+sub_element,
                    success: function success(data) {


                            toastr.success("Registro eliminado correctamente.");
                            Swal.close();
                            location.reload();

                    },
                    error: function error(data) {
                        console.log(data.responseText);
                        var obj = jQuery.parseJSON(data.responseText);

                        if (obj.error) {
                            toastr.error(obj.error);
                            Swal.close();
                        }
                    }
                });
            } else {
                Swal.close();
            }
        });
    }
</script>
<?php /**PATH /shared/httpd/water-management/resources/views/water-management/admin/panel/partials/sub-elements.blade.php ENDPATH**/ ?>