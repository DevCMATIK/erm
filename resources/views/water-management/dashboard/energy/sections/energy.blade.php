<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
        <div class="form-group">
            <label class="form-label">Seleccione un rango de fechas</label>
            <input type="text" class="form-control date-filter" name="date_filter" id="date_filter">
        </div>
    </div>
</div>

@include('water-management.dashboard.energy.sections.sub.stream')
@include('water-management.dashboard.energy.sections.sub.tension')
@include('water-management.dashboard.energy.sections.sub.power')


