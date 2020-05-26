<?php

Route::prefix('datatable/')->group(function () {
    Route::group(['middleware' => 'auth'], function() {
        //Groups
        Route::get('groups','User\Group\Controllers\GroupDatatableController@getData')->name('datatable.groups');
        //Client
        Route::get('check-points/{type}','Client\CheckPoint\Controllers\CheckPointDatatableController@getData')->name('datatable.check-points');
        Route::get('check-point-types','Client\CheckPoint\Type\Controllers\CheckPointTypeDatatableController@getData')->name('datatable.check-point-types');
        Route::get('check-point/dga-reports','Client\CheckPoint\Report\Controllers\CheckPointReportDatatableController@getData')->name('datatable.check-points-dga-reports');
        Route::get('check-point/dga-reports/{id}','Client\CheckPoint\Report\Controllers\CheckPointReportLogDatatableController@getData')->name('datatable.check-points-dga-reports-log');
        Route::get('production-areas','Client\ProductionArea\Controllers\ProductionAreaDatatableController@getData')->name('datatable.production-areas');
        Route::get('zones','Client\Zone\Controllers\ZoneDatatableController@getData')->name('datatable.zones');
        Route::get('areas','Client\Area\Controllers\AreaDatatableController@getData')->name('datatable.areas');
        Route::get('sub-zones/{zone}','Client\Zone\Sub\Controllers\SubZoneDatatableController@getData')->name('datatable.sub-zones');
        //WaterManagement
        Route::get('device-types','WaterManagement\Device\Type\Controllers\DeviceTypeDatatableController@getData')->name('datatable.device-types');
        Route::get('groups','WaterManagement\Group\Controllers\GroupDatatableController@getData')->name('datatable.groups');
        Route::get('historical-types','WaterManagement\Historical\Controllers\HistoricalTypeDatatableController@getData')->name('datatable.historical-types');
        Route::get('addresses','WaterManagement\Device\Address\Controllers\AddressDatatableController@getData')->name('datatable.addresses');
        Route::get('devices/{check_point_id}','WaterManagement\Device\Controllers\DeviceDatatableController@getData')->name('datatable.devices');
        Route::get('sensor-types','WaterManagement\Device\Sensor\Type\Controllers\SensorTypeDatatableController@getData')->name('datatable.sensor-types');
        Route::get('sensors/{device_id}','WaterManagement\Device\Sensor\Controllers\SensorDatatableController@getData')->name('datatable.sensors');
        Route::get('units','WaterManagement\Unit\Controllers\UnitDatatableController@getData')->name('datatable.units');
        Route::get('scales','WaterManagement\Scale\Controllers\ScaleDatatableController@getData')->name('datatable.scales');
        Route::get('interpreters/{type_id}','WaterManagement\Device\Sensor\Type\Controllers\InterpreterDatatableController@getData')->name('datatable.interpreters');

        //Inspection
        Route::get('check-list-types','Inspection\CheckList\Type\Controllers\CheckListTypeDatatableController@getData')->name('datatable.check-list-types');
        Route::get('check-lists','Inspection\CheckList\Controllers\CheckListDatatableController@getData')->name('datatable.check-lists');
        Route::get('check-list-modules/{check_list_id}','Inspection\CheckList\Module\Controllers\CheckListModuleDatatableController@getData')->name('datatable.check-list-modules');
        Route::get('check-list-sub-modules/{module_id}','Inspection\CheckList\Module\Sub\Controllers\CheckListSubModuleDatatableController@getData')->name('datatable.check-list-sub-modules');
        Route::get('check-list-controls/{sub_module_id}','Inspection\CheckList\Control\Controllers\CheckListControlDatatableController@getData')->name('datatable.check-list-controls');
        Route::get('sensor-triggers/{sensor_id}','WaterManagement\Device\Sensor\Trigger\Controllers\SensorTriggerDatatableController@getData')->name('datatable.sensor-triggers');
        Route::get('sensor-alarms/{sensor_id}','WaterManagement\Device\Sensor\Alarm\Controllers\SensorAlarmDatatableController@getData')->name('datatable.sensor-alarms');
        //commandLOG
        Route::get('command-log','WaterManagement\Command\Controllers\CommandViewDatatableController@getData')->name('datatable.command-log');
        Route::get('triggers-list','WaterManagement\Device\Sensor\Trigger\Controllers\SensorTriggerListDatatableController@getData')->name('datatable.triggers-list');
        Route::get('alarms-list','WaterManagement\Device\Sensor\Alarm\Controllers\AlarmListDatatableController@getData')->name('datatable.alarms-list');
        //mails
        Route::get('mail-reports','WaterManagement\Report\Controllers\MailReportDatatableController@getData')->name('datatable.mail-reports');
        //offline-devices
        Route::get('userDownloads','WaterManagement\Admin\Download\DownloadDatatableController@getData')->name('datatable.user-downloads');

        Route::get('offline-devices','WaterManagement\Admin\Device\Controllers\OfflineDevicesDatatableController@getData')->name('datatable.offline-devices');
        Route::get('offline-devices-log/{device_id}','WaterManagement\Admin\Device\Controllers\OfflineDevicesLogDatatableController@getData')->name('datatable.offline-devices-log');
        //commands-executed
        Route::get('commands-executed','Client\Command\Controllers\CommandsExecutedDatatableController@getData')->name('datatable.commands-executed');
        Route::get('clientOfflineDevices','Client\Devices\OfflineDevicesDatatableController@getData')->name('datatable.client-offline-devices');
        Route::get('clientOfflineDevicesList','Client\Devices\OfflineDevicesListDatatableController@getData')->name('datatable.client-offline-devices-list');
        Route::get('clientOfflineDevicesLog/{device_id}','Client\Devices\OfflineDevicesLogDatatableController@getData')->name('datatable.client-offline-devices-log');

    });
});
