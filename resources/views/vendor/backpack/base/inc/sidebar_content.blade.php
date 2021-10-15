<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-title'>Accommodation</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('room') }}'><i class='nav-icon la la-bed'></i> Rooms</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('comment') }}'><i class='nav-icon la la-comment'></i> Comments</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('image') }}'><i class='nav-icon la la-image'></i> Images</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('band') }}'><i class='nav-icon la la-pound-sign'></i> Rent Bands</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('perk') }}'><i class='nav-icon la la-check'></i> Perks</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('location') }}'><i class='nav-icon la la-map-marker-alt'></i> Locations</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('ballot') }}'><i class='nav-icon la la-ticket'></i> Ballots</a></li>
<li class='nav-title'>User Management</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-user'></i> Users</a></li>