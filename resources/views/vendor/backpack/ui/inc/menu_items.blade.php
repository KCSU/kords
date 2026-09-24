<x-backpack::menu-item :title="trans('backpack::base.dashboard')" icon="la la-home" :link="backpack_url('dashboard')" />

<x-backpack::menu-separator title="Accommodation" />
<x-backpack::menu-item title="Rooms" icon="la la-bed" :link="backpack_url('room')" />
<x-backpack::menu-item title="Comments" icon="la la-comment" :link="backpack_url('comment')" />
<x-backpack::menu-item title="Images" icon="la la-image" :link="backpack_url('image')" />
<x-backpack::menu-item title="Rent Bands" icon="la la-pound-sign" :link="backpack_url('band')" />
<x-backpack::menu-item title="Perks" icon="la la-check" :link="backpack_url('perk')" />
<x-backpack::menu-item title="Locations" icon="la la-map-marker-alt" :link="backpack_url('location')" />
<x-backpack::menu-item title="Ballots" icon="la la-ticket-alt" :link="backpack_url('ballot')" />

<x-backpack::menu-separator title="User Management" />
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
