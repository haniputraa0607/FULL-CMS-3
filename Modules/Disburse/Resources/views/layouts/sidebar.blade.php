<?php
use App\Lib\MyHelper;
$grantedFeature     = session('granted_features');
$configs    		= session('configs');
$level    			= session('level');

(session('advert')) ? $advert = session('advert') : $advert = null;

?>

<li class="sidebar-toggler-wrapper hide">
	<div class="sidebar-toggler">
		<span></span>
	</div>
</li>

<li class="nav-item {{($menu_active == 'disburse-dasboard') ? 'active' : ''}}">
	<a href="{{url('disburse/dashboard')}}" class="nav-link nav-toggle">
		<i class="fa fa-th"></i>
		<span class="title">Dashboard</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-success') ? 'active' : ''}}">
	<a href="{{url('disburse/list/success')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Success</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-fail') ? 'active' : ''}}">
	<a href="{{url('disburse/list/fail')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Fail</span>
	</a>
</li>

<li class="nav-item {{($menu_active == 'disburse-list-trx') ? 'active' : ''}}">
	<a href="{{url('disburse/list/trx')}}" class="nav-link nav-toggle">
		<i class="fa fa-list"></i>
		<span class="title">List Transaction Online</span>
	</a>
</li>