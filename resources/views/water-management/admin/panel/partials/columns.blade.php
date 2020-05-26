<h5><i class="fas fa-arrows-alt"></i> Dispositivos Disponibles</h5>
<div class="row mb-5">
    <div class="col-xl-12">
        @include('water-management.admin.panel.partials.available-devices')
    </div>
</div>
<h5><i class="fas fa-cog"></i> Configurar Columnas</h5>
<div class="row mt-2">
    @for($i = 1; $i <= $subZone->configuration->columns; $i++)
        <div class="col-sm-12 col-md-12 col-xl-{{ (12 / (int)$subZone->configuration->columns) }} p-3" id="column_{{$subZone->id}}_{{$i}}">
            <div class="border p-2 rounded-plus pb-6">
                @if($subZone->configuration->block_columns == 1)
                    @include('water-management.admin.panel.partials.column')
                @endif
                <ul class="draginto border p-2" id="drag_{{$subZone->id}}_{{$i}}">
                    @include('water-management.admin.panel.partials.sub-elements')
                </ul>
            </div>
        </div>
    @endfor
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
