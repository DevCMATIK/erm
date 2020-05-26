<?php $__env->startSection('page-title','Editar Mail: '.$mail->name); ?>
<?php $__env->startSection('page-icon','envelope'); ?>
<?php $__env->startSection('more-css'); ?>
    <?php echo includeCss('plugins/summernote/summernote.css'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('more-scripts'); ?>
    <?php echo includeScript('plugins/summernote/summernote.js'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="float-right">
                <?php echo makeLink('/mails','Volver a Correos','fa-arrow-left' ,'btn-primary','btn-sm'); ?>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Formulario de Modificacion
                    </h2>
                    <div class="panel-toolbar">`
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form  role="form"  id="mail-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('put'); ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control"  name="name" value="<?php echo e($mail->name); ?>">
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label">Asunto</label>
                                        <input type="text" class="form-control"  name="subject" value="<?php echo e($mail->subject); ?>">
                                    </div>
                                    <div class="col-2">
                                        <label class="custom-control custom-checkbox">
                                            <label class="form-label">Visibilidad</label><br>
                                            <input type="checkbox" class="custom-control-input" value="1" name="share_with_all" <?php if($mail->share_with_all == 1): ?> checked <?php endif; ?>>
                                            <span class="custom-control-label">Todos</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Encabezado</label>
                                <textarea name="header" class="js-summernote" id="header"><?php echo e($mail->header); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cuerpo del correo</label>
                                <textarea name="body" class="js-summernote" id="body"><?php echo e($mail->body); ?></textarea>
                            </div>


                            <div class="form-group my-2">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col table-responsive">
                                <h5>Listado de conectores</h5>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $attachables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($attachable->code); ?></td>
                                            <td><?php echo e($attachable->name); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="2">No ha configurado los conectores</td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-extra-scripts'); ?>
    <script>

        $(document).ready(function()
        {
            let form = $("#mail-form");
            form.on('submit',function(e) {
                e.preventDefault();
                $('#mail-form .alert').remove();
                $.ajax({
                    url     : '/mails/<?php echo e($mail->id); ?>',
                    type    : 'POST',
                    data    : form.serialize(),
                    dataType: "json",
                    success : function ( json )
                    {
                        $('.form-control').removeClass('is-invalid').addClass('is-valid');
                        $('.error-tooltip').remove();
                        toastr.success( "Se ha completado correctamente el formulario." , "Formulario Completado!" );
                        form.prepend("<div class='alert alert-success alert-dismissible fade show'>"+json.success+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        location.href = '/mails';
                    },
                    error   : function ( response )
                    {
                        let messages = jQuery.parseJSON(response.responseText);
                        if(response.status === 401){
                            if(messages.error){
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>"+messages.error+"<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }else{
                                form.prepend("<div class='alert alert-danger alert-dismissible fade show'>No se pudo completar la acción.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                            }
                        }else if( response.status === 500) {
                            form.prepend("<div class='alert alert-danger alert-dismissible fade show'>Ha Ocurrido en el servidor.<button type='button' class='close' data-dismiss='alert'>×</button></div>");
                        }else{
                            handleFormErrors(messages);
                        }
                    }
                })
            });
            //init default
            $('.js-summernote').summernote(
                {
                    height: 200,
                    tabsize: 2,
                    placeholder: "Type here...",
                    dialogsFade: true,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]
                            ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    hint:
                        {
                            mentions: <?php echo json_encode($attachables->pluck('code')->toArray()); ?>,
                            match: /\B@(\w*)$/,
                            search: function(keyword, callback)
                            {
                                callback($.grep(this.mentions, function(item)
                                {
                                    return item.indexOf(keyword) == 0;
                                }));
                            },
                            content: function(item)
                            {
                                return ' '+item+' ';
                            }
                        }
                });


        });

    </script>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /shared/httpd/water-management/resources/views/system/mail/edit.blade.php ENDPATH**/ ?>