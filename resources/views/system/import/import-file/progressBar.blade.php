<h5>Proceso de Carga  <label class="float-right">{{ $importFile->processed_count }}/{{ $importFile->temps_count }} </label></h5>
<div class="progress m-t-10">
    <div class="progress-bar bg-info  progress-bar" style="width: {{ $percentaje }}%; height:15px;" role="progressbar">
        {{ $percentaje }}%
    </div>
</div>
<div class="note">
    <strong>{{ $percentaje }}% Completado.</strong>
</div>
