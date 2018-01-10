<?php

Route::set('custom/route/{id}/of/{name}/blabla/{desc?}','default', 'home', 'CustomRouteOne');
Route::set('custom/route/blank/{id?}','default', 'home', 'CustomRouteTwo');