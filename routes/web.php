<?php

use App\Domain\WaterManagement\Main\Report;
use Carbon\Carbon;

Route::middleware('auth')->group(function() {
    Route::view('d-electric','test.electric.index');
    Route::resource('groups','User\Group\Controllers\GroupController');
    //Client
    Route::get('getSubZones/{zone_id}/{check_point_id?}','Client\CheckPoint\Controllers\GetSubZonesController@getSubZones');
    Route::resource('check-points','Client\CheckPoint\Controllers\CheckPointController');
    Route::get('check-point/dga/{id}','Client\CheckPoint\Controllers\CheckPointDGAController@store');
    Route::get('check-point/reports','Client\CheckPoint\Report\Controllers\CheckPointReportController@index')->name('check-point.reports');
    Route::get('check-point/dga_reports/{id}','Client\CheckPoint\Report\Controllers\CheckPointReportController@log')->name('check-point.reports-log');
    Route::get('check-point-labels','Client\CheckPoint\Label\Controllers\CheckPointLabelController@index')->name('check-point-label');
    Route::post('check-point-labels','Client\CheckPoint\Label\Controllers\CheckPointLabelController@store');
    Route::get('check-point-flows','Client\CheckPoint\Flow\Controllers\AuthorizedFlowController@index')->name('check-point-flows');
    Route::post('check-point-flows','Client\CheckPoint\Flow\Controllers\AuthorizedFlowController@store');
    Route::resource('check-point-types','Client\CheckPoint\Type\Controllers\CheckPointTypeController');
    Route::resource('production-areas','Client\ProductionArea\Controllers\ProductionAreaController');
    Route::get('productionArea/zones/{id}', 'Client\ProductionArea\Controllers\ProductionAreaZonesController@index');
    Route::post('productionArea/zones/{id}', 'Client\ProductionArea\Controllers\ProductionAreaZonesController@storeZones');
    Route::get('area-zones/{area}','Client\Area\Controllers\AreaZonesController@index');
    Route::post('area-zones/{area}','Client\Area\Controllers\AreaZonesController@storeZones');
    Route::resource('areas','Client\Area\Controllers\AreaController');
    Route::resource('zones','Client\Zone\Controllers\ZoneController');
    Route::get('zoneSerialization','Client\Zone\Controllers\ZoneSerializationController@index');
    Route::post('zoneSerialization','Client\Zone\Controllers\ZoneSerializationController@serialize');
    Route::resource('sub-zones','Client\Zone\Sub\Controllers\SubZoneController');
    Route::get('subZoneSerialization/{zone_id}','Client\Zone\Sub\Controllers\SubZoneSerializationController@index');
    Route::post('subZoneSerialization/{zone_id}','Client\Zone\Sub\Controllers\SubZoneSerializationController@serialize');
    Route::get('subZoneHourCosts','Client\Zone\Sub\Controllers\SubZoneEnergyCostController@index')->name('sub-zone-hour-cost');
    Route::post('subZoneHourCosts','Client\Zone\Sub\Controllers\SubZoneEnergyCostController@store');
    Route::get('mailReportSerialization/{id}','WaterManagement\Report\Controllers\SensorsSerializeController@index');
    Route::post('mailReportSerialization/{id}','WaterManagement\Report\Controllers\SensorsSerializeController@serialize');
    //WaterManagement
    Route::resource('device-types','WaterManagement\Device\Type\Controllers\DeviceTypeController');
    Route::resource('groups','WaterManagement\Group\Controllers\GroupController');
    Route::get('groupSubZones/{group_id}','WaterManagement\Group\Controllers\GroupSubZonesController@index');
    Route::post('groupSubZones/{group_id}','WaterManagement\Group\Controllers\GroupSubZonesController@store');
    Route::resource('historical-types','WaterManagement\Historical\Controllers\HistoricalTypeController');
    Route::resource('addresses','WaterManagement\Device\Address\Controllers\AddressController');
    Route::resource('devices','WaterManagement\Device\Controllers\DeviceController');
    Route::resource('sensor-types','WaterManagement\Device\Sensor\Type\Controllers\SensorTypeController');
    Route::resource('sensors','WaterManagement\Device\Sensor\Controllers\SensorController');
    Route::resource('units','WaterManagement\Unit\Controllers\UnitController');
    Route::resource('scales','WaterManagement\Scale\Controllers\ScaleController');
    Route::resource('interpreters','WaterManagement\Device\Sensor\Type\Controllers\InterpreterController');
    //User Groups
    Route::get('userGroups','Manage\Group\UserGroupController@index')->name('userGroups.index');
    Route::get('getUsersFromGroup/{group_id}','Manage\Group\UserGroupController@usersFromGroup')->name('userGroups.usersFromGroup');
    Route::post('handleUsersFromGroup/{group_id}','Manage\Group\UserGroupController@handleUsersFromGroup')->name('userGroups.handleUsersFromGroup');
    Route::post('handleUserGroups/{user_id}','User\Group\Controllers\AdminUserGroupController@handleUserGroups');
    Route::get('userGroups/admin/{id}','User\Group\Controllers\AdminUserGroupController@index');
    //CheckList Admin
    Route::resource('check-list-types','Inspection\CheckList\Type\Controllers\CheckListTypeController');
    Route::resource('check-lists','Inspection\CheckList\Controllers\CheckListController');
    Route::get('check-list-preview/{slug}','Inspection\CheckList\Controllers\CheckListPreviewController@index');
    Route::resource('check-list-modules','Inspection\CheckList\Module\Controllers\CheckListModuleController');
    Route::resource('check-list-sub-modules','Inspection\CheckList\Module\Sub\Controllers\CheckListSubModuleController');
    Route::resource('check-list-controls','Inspection\CheckList\Control\Controllers\CheckListControlController');
    //Devices Admin
    Route::get('admin/devices','WaterManagement\Admin\Device\Controllers\AdminDeviceController@index')->name('admin.devices');
    Route::get('getSubZonesCombo/{zone_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceController@getSubZonesCombo');
    Route::get('admin/SubZone/{sub_zone_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceController@adminSubZone');
    Route::get('getBooleanForm/{sensor_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceBooleanFormController@index');
    Route::get('getScaleForm/{sensor_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceScaleFormController@index');
    Route::post('storeSensorLabel/{sensor_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceBooleanFormController@store');
    Route::post('storeSensorScale/{sensor_id}','WaterManagement\Admin\Device\Controllers\AdminDeviceScaleFormController@store');
    Route::get('addNewScale/{row}','WaterManagement\Admin\Device\Controllers\AdminDeviceScaleFormController@newScale');
    Route::get('deleteDisposition/{id}','WaterManagement\Admin\Device\Controllers\AdminDeviceScaleFormController@deleteDisposition');
    Route::get('createAverageForSensor/{sensor}/{average}','WaterManagement\Admin\Device\Sensor\Behavior\Controllers\CreateAverageForSensorController');
    Route::get('disposition-lines/{disposition_id}','WaterManagement\Admin\Device\Sensor\Disposition\Controllers\DispositionLinesController@index');
    Route::post('disposition-lines/{disposition_id}','WaterManagement\Admin\Device\Sensor\Disposition\Controllers\DispositionLinesController@store');
    Route::get('deleteLineInDisposition/{line_id}','WaterManagement\Admin\Device\Sensor\Disposition\Controllers\DispositionLinesController@deleteLine');
    Route::get('addNewLine','WaterManagement\Admin\Device\Sensor\Disposition\Controllers\DispositionLinesController@addLine');
    Route::get('check-point-grid/{check_point_id}','Client\CheckPoint\Grid\Controllers\CheckPointGridController@index');
    Route::get('resetGrid/{check_point_id}','Client\CheckPoint\Grid\Controllers\CheckPointGridController@reset');
    Route::post('CheckPointSensorsSerialization/{check_point_id}','Client\CheckPoint\Grid\Controllers\CheckPointGridController@serialize');
    //ADMIN PANEL
    Route::get('admin-panel','WaterManagement\Admin\Panel\AdminPanelController@index')->name('admin-panel');
    Route::get('admin-panel/{sub_zone_id}','WaterManagement\Admin\Panel\AdminPanelController@adminSubZone');
    Route::get('admin-panel/changeColumns/{sub_zone_id}/{columns}','WaterManagement\Admin\Panel\AdminPanelController@changeColumns');
    Route::get('admin-panel/getColumns/{sub_zone_id}','WaterManagement\Admin\Panel\AdminPanelController@getColumns');
    Route::get('admin-panel/changeBlocked/{sub_zone_id}/{checked}','WaterManagement\Admin\Panel\AdminPanelController@changeBlocked');
    // Panel columns
    Route::get('panel-columns/changeName','WaterManagement\Admin\Panel\PanelColumnController@changeColumnName');
    Route::get('panel-columns/updateItems','WaterManagement\Admin\Panel\PanelColumnController@updateItems');
    Route::get('removeSubElement/{sub_element}','WaterManagement\Admin\Panel\PanelColumnController@removeSubElement');
    //Sub Element Config
    Route::get('subElementConfig/{sub_element}','WaterManagement\Admin\Panel\SubElementController@index');
    Route::get('subElement/updateSensors','WaterManagement\Admin\Panel\SubElementController@updateSensors');
    Route::get('sensorShowInDashboard','WaterManagement\Admin\Panel\SubElementController@showSensorInDashboard');
    Route::get('useAsChart','WaterManagement\Admin\Panel\SubElementController@useAsChart');
    Route::get('chartNotNeeded','WaterManagement\Admin\Panel\SubElementController@chartNotNeeded');
    Route::get('isNotAnOutput','WaterManagement\Admin\Panel\SubElementController@isNotAnOutput');
    Route::get('useAsChart','WaterManagement\Admin\Panel\SubElementController@useAsChart');
    Route::get('useAsChart/digital','WaterManagement\Admin\Panel\SubElementController@useAsChartDigital');
    Route::post('updateDigitalMeanings/{sensor}','WaterManagement\Admin\Panel\SubElementController@updateDigitalMeanings');
    //SensorRanges
    Route::get('sensorRanges/{sensor_id}','WaterManagement\Admin\Panel\SensorRangesController@index');
    Route::post('sensorRanges/{sensor_id}','WaterManagement\Admin\Panel\SensorRangesController@store');
    //ofline devces
    Route::get('offline-devices','WaterManagement\Admin\Device\Controllers\OfflineDevicesController@index')->name('offline-devices');
    Route::get('offline-devices-list','Client\Devices\OfflineDevicesController@list')->name('offline-devices');
    Route::get('device-disconnections/{device_id}','WaterManagement\Admin\Device\Controllers\OfflineDevicesController@getLogView');
    //DASHBOARD
    Route::namespace('WaterManagement\Dashboard')->group(function(){
        Route::namespace('Controllers')->group(function() {
            Route::get('dashboard','DashboardController@dashboardMain')->name('dashboard.index');
            Route::get('dashboard/{sub_zone_id}','DashboardController@subZoneDashboard');
            Route::get('getDeviceContent/{check_point}','DashboardController@getDeviceContent');
            Route::get('getDashboardContent/{sub_zone_id}','DashboardController@getDashboardContent');
            Route::get('getDashboardContentElectric/{sub_zone_id}','DashboardController@getDashboardContentElectric');
            Route::get('getControlContent/{sub_zone_id}','DashboardController@getControlContent');
            Route::get('getSubZoneDeviceState/{sub_zone_id}','SubZoneDevicesStateController');
            Route::get('getZoneDeviceState/{zone_id}','ZoneDevicesStateController');
            Route::get('getSubZoneDeviceAlarm/{sub_zone_id}','SubZoneDevicesAlarmController');
            Route::get('getZoneDeviceAlarm/{zone_id}','ZoneDevicesAlarmController');
            Route::get('setAlarmAccused/{device}','AlarmAccusedController');


            Route::get('dashboard/control/{sub_zone_id}','DashboardController@controlDashboard');
            Route::get('dashboard/detail/{check_point}','DashboardController@deviceDashboard');


        });

        Route::namespace('Energy\Controllers')->group(function(){
            Route::get('dashboard-energy/{subZone}','EnergyController@index')->name('dashboard-energy');
            Route::get('energy/get-consumption-data','Consumption\ConsumptionDataController@getConsumptionData');
            Route::get('energy/get-zone-consumption-data','Consumption\ConsumptionDataController@getZoneConsumptionData');
            Route::get('energy/get-var-data','Data\VarDataController');
            //charts
            Route::get('energy/charts/consumption/{sub_zone}','Chart\ConsumptionChartController');
        });
        //electricity values
        Route::get('getEnergyValues','Electricity\EnergyValuesController');
        Route::get('getPowerValues','Electricity\PowerValuesController');
        Route::get('getStreamValues','Electricity\StreamValuesController');
        Route::get('getTensionValues','Electricity\TensionValuesController');
        //kpi
        //Alarms
        Route::get('dashboard-alarms','Alarm\Controllers\AlarmDashboardController@index');
        Route::get('dashboard-alarms/getActiveAlarmsTable','Alarm\Controllers\ActiveAlarmsTableController@index');
        Route::get('dashboard-alarms/getLastAlarmsTable','Alarm\Controllers\LastAlarmsTableController@index');
        Route::get('remindMeAlarm','Alarm\Controllers\ActiveAlarmsTableController@remindMeAlarm');

        //CHART
        Route::get('getDataAsChart/{device_id}/{sensor_id}','Chart\ChartController@index');
        Route::get('getDataAsChartExternal/{device_id}/{sensor_id}','Chart\ChartController@indexExternal');
        Route::get('getDataForChart/{device_id}/{sensor_id}','Chart\ChartDataController');
        Route::get('getDataForChartAverage/{device_id}/{sensor_id}','Chart\ChartDataAverageController');
        Route::get('getDataForChartDailyAverage/{device_id}/{sensor_id}','Chart\ChartDailyAveragesController');
        Route::get('downloadDataFromChart/{device_id}/{sensor_id}','Chart\ExportChartData');
        Route::get('downloadDataFromEnergy','Chart\ExportEnergyData');
        Route::get('downloadConsumptions/{sub_zone_id}','Chart\ExportConsumptionsData');
        Route::post('downloadDataFromChartTotal','Chart\ExportDataTotal');
        //EnergyCharts
        Route::get('getEnergyChart/{sub_zone_id}','Chart\Electric\EnergyChartController');
        Route::get('getTensionChart','Chart\Electric\TensionChartController');
        Route::get('getStreamChart','Chart\Electric\StreamChartController');
        Route::get('getPowerChart','Chart\Electric\PowerChartController');
        //KPI
        Route::prefix('kpi/')->namespace('Kpi')->group(function () {
            Route::get('getOnlineDevices','OnlineDevicesController');
            Route::get('getAlarmsTotal','AlarmsTotalController');
            Route::get('getAlarmsOn','KpiAlarmsOnController');
            Route::get('getLastAlarm','LastAlarmController');
            Route::get('getLastUpdate','LastUpdateController');
            Route::get('getCupLevels','CupLevelsController');
        });
    });
    //dashboards
    Route::get('/sendCommand','WaterManagement\Command\Controllers\CommandController@sendCommand');
    Route::get('command-log','WaterManagement\Command\Controllers\CommandViewController@index')->name('command-log.index');
    //BACKUPS
    Route::get('checkDevicesData','Data\Controllers\ProcessMonthlyDataController@index');
    Route::get('syncDevices','Data\Controllers\ProcessMonthlyDataController@syncDevices');
    Route::get('backupDevice/{device_id}','Data\Controllers\HandleBackupDataJobsController@backupDevice');
    Route::get('backupDeviceByMonth/{month}/{device_id}','Data\Controllers\HandleBackupDataJobsController@backupDeviceByMonth');
    Route::get('backupDeviceBySensor/{month}/{device_id}/{address}','Data\Controllers\HandleBackupDataJobsController@backupDeviceBySensor');
    Route::get('sensorAveragesBackup/{sensor}','Data\Controllers\BackupSensorAveragesController');
    //TRiggers
    Route::resource('sensor-triggers','WaterManagement\Device\Sensor\Trigger\Controllers\SensorTriggerController');
    Route::get('triggers-list','WaterManagement\Device\Sensor\Trigger\Controllers\SensorTriggerListController@index')->name('triggers-list');
    Route::get('userDownloads','WaterManagement\Admin\Download\DownloadController@index')->name('user.downloads');
    Route::get('triggerLog/{trigger}','WaterManagement\Device\Sensor\Trigger\Controllers\SensorTriggerListController@getLog');
    Route::get('triggerActive/{trigger}/{is_active}','WaterManagement\Device\Sensor\Trigger\Controllers\TriggerActiveController');
    //ALARMS
    Route::resource('sensor-alarms','WaterManagement\Device\Sensor\Alarm\Controllers\SensorAlarmController');
    Route::get('sensor-alarm-logs/{id}','WaterManagement\Device\Sensor\Alarm\Controllers\AlarmLogController');
    Route::get('alarms-list','WaterManagement\Device\Sensor\Alarm\Controllers\AlarmListController')->name('alarms-list');
    Route::get('alarm/accused/{id}','WaterManagement\Device\Sensor\Alarm\Controllers\AccuseAlarmController');
    Route::get('testValue/{sensor}/{disposition?}','WaterManagement\Admin\Device\Controllers\TestValueController');
    //Chronometers
    Route::resource('sensor-chronometers','WaterManagement\Device\Sensor\Chronometer\Controllers\SensorChronometerController');
    // UserSubZones
    Route::get('userSubZones/{id}','User\SubZone\Controllers\UserSubZonesController@index');
    Route::post('userSubZones/{id}','User\SubZone\Controllers\UserSubZonesController@storeSubZones');
    Route::get('userSubZones/detail/{id}','User\SubZone\Controllers\UserSubZonesController@getUserSubZones');
    Route::post('userProductionAreas/{id}','User\SubZone\Controllers\UserSubZonesController@handleProductionAreas');

    //MailReport
    Route::resource('mail-reports','WaterManagement\Report\Controllers\MailReportController');
    Route::get('mail-reportActive/{report_id}/{is_active}','WaterManagement\Report\Controllers\IsActiveController@index');
    Route::get('report/filterSensors','WaterManagement\Report\Controllers\Partial\FilterSensorsController');
    //commands executed
    Route::get('commands-executed','Client\Command\Controllers\CommandsExecutedController@index')->name('commands-executed');
    Route::get('export-commands-executed','Client\Command\Controllers\CommandsExecutedController@export');
    //export data
    Route::get('exportData','Data\Export\ExportDataController@index')->name('export.data');
    Route::post('exportDataTest','Data\Export\TestExportController')->name('export.data-test');
    Route::get('getCheckPoints','Data\Export\ExportDataController@getCheckPoints');


    Route::get('clientOfflineDevices','Client\Devices\OfflineDevicesController@index')->name('client-offline-devices');
    Route::get('client-device-disconnections/{id}','Client\Devices\OfflineDevicesController@getLog');
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/test','TestController');
Route::get('/test2',function(){
   dd(\App\Domain\Client\CheckPoint\DGA\CheckPointReport::get());
});

Route::get('download-file/{id}',function($id){
    $file = \App\Domain\Data\Export\ExportReminderFile::find($id);
    return response()->download(storage_path('app/public/'.$file->file), \Illuminate\Support\Str::slug($file->display_name,'_').'.xlsx');
});

Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});


// Clear view cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

// Entorno de Test:
Route::get('TestView', function() {
    return view('test.view');
});
